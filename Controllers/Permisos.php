<?php
	class Permisos extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			parent::__construct();
		}

		public function GetPermisosRol(int $idRol)
		{
			$intIdRol = intval(StrClean($idRol));
			if($intIdRol > 0) 
			{
				$arrModulos = $this->model->SelectModulos();
				$arrPermisosRol = $this->model->SelectPermisosRol($intIdRol);

				$arrPermisos = array('r'=>0,'w'=>0,'u'=>0,'d'=>0);
				$arrPermisoRol = array('idrol' => $idRol);

				if(empty($arrPermisosRol))
				{
					for($i=0;$i<count($arrModulos);$i++)
					{
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}else
				{
					for($i=0;$i<count($arrModulos);$i++)
					{
						$arrPermisos = array('r'=>0,'w'=>0,'u'=>0,'d'=>0);
						if(isset($arrPermisosRol[$i]))
						{
							$arrPermisos = array(	'r'=>$arrPermisosRol[$i]['r'],
													'w'=>$arrPermisosRol[$i]['w'],
													'u'=>$arrPermisosRol[$i]['u'],
													'd'=>$arrPermisosRol[$i]['d']
												);
						}
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
				$arrPermisoRol['modulos'] = $arrModulos;
				$html = GetModal("modalPermisos",$arrPermisoRol);
			}
			die();
		}

		public function SetPermisos(){
			if($_POST)
			{
				$intIdRol = intval($_POST['idrol']);
				$modulos = $_POST['modulos'];

				$this->model->DeletePermisos($intIdRol);
				foreach ($modulos as $modulo) {
					$idModulo = $modulo['idmodulo'];
					$r = empty($modulo['r']) ? 0 : 1;
					$w = empty($modulo['w']) ? 0 : 1;
					$u = empty($modulo['u']) ? 0 : 1;
					$d = empty($modulo['d']) ? 0 : 1;
					$requestPermiso = $this->model->InsertPermisos($intIdRol, $idModulo, $r, $w, $u, $d);
				}
				if($requestPermiso > 0)
				{
					$arrResponse = array(	'estado'=> true,
											'msg'	=> 'Permisos asignados correctamente.');
				}else
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'No es posible asinar los permisos.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>

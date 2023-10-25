<?php  
    
    function menus(){

        $padres =  DB::select('SELECT distinct 
                                    id_padre
                                FROM
                                    lista_control_accesos
                                        LEFT JOIN
                                    recursos ON recursos.id = lista_control_accesos.id_recursos
                                        left join
                                    menus ON menus.id_recursos = lista_control_accesos.id_recursos
                                WHERE
                                    1 
                                    AND lista_control_accesos.id_users = ?
                                    and id_padre = ?
                                    and menus.estatus = ?
                                GROUP BY id_padre',[ Auth::user()->id,0,1]);
        $menus = "";
        foreach ($padres as $padre) {

            $hijos = DB::select('SELECT distinct
                                    menus.*
                                FROM
                                    lista_control_accesos
                                        LEFT JOIN
                                    recursos ON recursos.id = lista_control_accesos.id_recursos
                                        left join
                                    menus ON menus.id_recursos = lista_control_accesos.id_recursos
                                      
                                WHERE
                                    1 
                                    AND lista_control_accesos.id_users = ?
                                    and id_padre = ?
                                    and menus.estatus = ?
                                    order by orden asc',[ Auth::user()->id,$padre->id_padre,1]);

            foreach ($hijos as $hijo) {

                $subhijos = DB::select('SELECT distinct
                                    menus.*
                                FROM
                                    lista_control_accesos
                                        LEFT JOIN
                                    recursos ON recursos.id = lista_control_accesos.id_recursos
                                        left join
                                    menus ON menus.id_recursos = lista_control_accesos.id_recursos
                                WHERE
                                    1 
                                    AND lista_control_accesos.id_users = ?
                                    and id_padre = ?
                                    and menus.estatus = ?
                                    order by orden asc',[ Auth::user()->id,$hijo->id,1]);
                $div = '';

                if ($subhijos) {

                    $menus .=   '<li>
                                    <a href="javaScript:void();>
                                        <!--i class="'.$hijo->icono.' menu-icon"></i-->
                                        <i class="'.$hijo->icono.' menu-icon"></i>
                                        <!--img src="'. asset("assets/images/svg-icon/widgets.svg").'" class="img-fluid" alt="widgets"-->
                                        <span>'.$hijo->nombre.'</span>
                                        <i class="feather icon-chevron-right pull-right"></i>
                                    </a>';

                } else {
                    $menus .=   '<li>
                                    <a href="'.$hijo->url.'">
                                       <i class="'.$hijo->icono.' menu-icon"></i>
                                       <!--img src="'. asset("assets/images/svg-icon/widgets.svg").'" class="img-fluid" alt="widgets"-->
                                        <span>'.$hijo->nombre.'</span>
                                    </a>
                                </li>';
                }
                
                $menus .= ' <ul class="vertical-submenu">';

                foreach ($subhijos as $subhijo) {

                    $nivel3 = DB::select('SELECT distinct
                                    menus.*
                                FROM
                                    lista_control_accesos
                                        LEFT JOIN
                                    recursos ON recursos.id = lista_control_accesos.id_recursos
                                       
                                        left join
                                    menus ON menus.id_recursos = lista_control_accesos.id_recursos
                                      
                                WHERE
                                    1 
                                    AND lista_control_accesos.id_users = ?
                                    and id_padre = ?
                                    and menus.estatus = ?
                                    order by orden asc',[ Auth::user()->id,$subhijo->id,1]);

                        if ($nivel3) {

                            $menus .=   '<li>
                                            <a href="#'.$subhijo->nombre.'" >
                                                <i class="'.$subhijo->icono.' menu-icon"></i>
                                                <span class="menu-title">'.$subhijo->nombre.'</span>
                                                <i class="feather icon-chevron-right pull-right"></i>
                                            </a>';

                            $menus .=   '<ul class="vertical-submenu">';
                            foreach ($nivel3 as $nivel) {
                                
                                $menus .=   '<li"> 
                                                <a class="nav-link" href="'.$nivel->url.'">
                                                    '.$nivel->nombre.'
                                                </a>
                                            </li>';

                            }$menus .=  "</ul></div>";
                        } else {

                            $menus .=   '<li"> 
                                            <a class="nav-link" href="'.$subhijo->url.'">
                                                '.$subhijo->nombre.'
                                            </a>
                                        </li>';
                        }
                        
                }$menus .=  "</ul>";

            }

        }

        echo $menus;
    }

?>
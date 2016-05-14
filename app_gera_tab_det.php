<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("app_inic.php");


$accao = @$_REQUEST['accao'];

$table_name = @$_REQUEST['table_name'];
$table_desig =  @$_REQUEST['table_desig'];
$column_name =  @$_REQUEST['column_name'];
$display_type =  @$_REQUEST['display_type'];
$file_template =  @$_REQUEST['file_template'];

if ($accao == 'TABLE_COLS') {

    $result = '';
    
    if ($table_name != ''){

        $sql = "SELECT COLUMN_NAME,DATA_TYPE,DATA_LENGTH,DATA_PRECISION,DATA_SCALE,NULLABLE ".
               "FROM USER_TAB_COLUMNS ".
               "WHERE TABLE_NAME = '$table_name' ".
               "ORDER BY COLUMN_ID ";
        $res = $db->execFetchAll($sql, "Table Query");
        $i = 0;
        foreach ($res as $row) {
            $result .= "<tr>";
            $result .= "<td><input id='column_name' name='column_name' value='".$row['COLUMN_NAME']."' class='form-control'></td>";
            $result .= "<td><span  class='form-control'>".$row['DATA_TYPE']."</span></td>";
            $result .= "<td>".$row['DATA_LENGHT']."</td>";
            $result .= "<td>".$row['DATA_PRECISION']."</td>";
            $result .= "<td>".$row['DATA_SCALE']."</td>";
            $result .= "<td><span  class='form-control'>".$row['NULLABLE']."</span></td>";

            $result .= "<td>";
            $result .= "<select id='display_type' name='display_type' value='".$display_type[$i]."' class='form-control'>";
            if ($display_type[$i]=='INPUT')
                $result .= "<option value='INPUT' seleted>Input Text</option>";
            else
                $result .= "<option value='INPUT'>Input Text</option>";

            if ($display_type[$i]=='SELECT')
                $result .= "<option value='SELECT' selected>List</option>";
            else
                $result .= "<option value='SELECT'>List</option>";

            if ($display_type[$i]=='CHECKBOX')
                $result .= "<option value='CHECKBOX' selected>Check-Box</option>";
            else
                $result .= "<option value='CHECKBOX'>Check-Box</option>";

                if ($display_type[$i]=='HIDDEN')
                    $result .= "<option value='HIDDEN' selected>Hidden</option>";
                else
                    $result .= "<option value='HIDDEN'>Hidden</option>";
            $result .= "</select>";
            $result .= "</td>";
            $result .= "</tr>";
            
            $i += 1;
        }

        echo $result;
    } 

} elseif ($accao == 'GERA_FX') {

    if ($table_name != '' && $file_template != '') {

        if (file_exists($file_template)) {

          $file = file_get_contents($file_template);

          $colunas = explode(",",$column_name);
          $coltype = explode(",",$display_type);
          
          $filename = "app_manut_".strtolower($table_name).".php";

          $file = str_replace("%TABLENAME%", $table_name, $file);
          $file = str_replace("%FILENAME%", $filename, $file);
          $file = str_replace("%DATE%", date("Y.m.d"), $file);
          $file = str_replace("%TABLE_DESIG%", $table_desig, $file);

          $i = 0;
          $cols_header = '';
          $cols_dialog = '';
          foreach ($colunas as $col) {
              $col = strtolower($col);
              if ($coltype[$i] == 'HIDDEN')
                  $cols_header .= "\n".'                <th data-field="'.strtolower($col).'" data-visible="false" data-searchable="false">'.strtolower($col).'</th>';
              else
                  $cols_header .= "\n".'                <th data-field="'.strtolower($col).'">'.strtolower($col).'</th>';


              if ($coltype[$i] == 'INPUT') {
                  $cols_dialog .= "\n".
                                  "\n".'                    <div class="form-group"> '.
                                  "\n".'                       <label>'.$col.'</label> '.
                                  "\n".'                       <input type="text" class="form-control" name="'.$col.'" placeholder="'.$col.'"> '.
                                  "\n".'                    </div> ';
              } elseif ($coltype[$i] == 'CHECKBOX') {
                  $cols_dialog .= "\n".'                    <div class="form-group"> '.
                                  "\n".'                        <label>'.$col.'</label>'.
                                  "\n".'                        <input type="checkbox" name="'.$col.'" check_val="" uncheck_val="" placeholder="'.$col.'">'.
                                  "\n".'                    </div>';
              } elseif ($coltype[$i] == 'SELECT') {
                  $cols_dialog .= "\n".
                                  "\n".'                    <div class="form-group"> '.
                                  "\n".'                       <label>'.$col.'</label> '.
                                  "\n".'                       <select class="form-control" name="'.$col.'" placeholder="'.$col.'"> '.
                                  "\n".'                          <option value=""></option> '.
                                  "\n".'                       </select> '.
                                  "\n".'                    </div> ';
              } elseif ($coltype[$i] == 'HIDDEN') {
                  $cols_dialog .= "\n".
                                  "\n".'                    <div class="form-group"> '.
                                  "\n".'                       <input type="hidden" class="form-control" name="'.$col.'" placeholder="'.$col.'"> '.
                                  "\n".'                    </div> ';
              }

              $i += 1;
          }
          $cols_header .= "\n".'                <th data-field="action" '.
                          "\n".'                  data-align="center" '.
                          "\n".'                  data-formatter="actionFormatter" '.
                          "\n".'                  data-events="actionEvents"><?php echo $ui_action;?></th> ';

          $file = str_replace("%COLS_HEADER%", $cols_header, $file);
          $file = str_replace("%COLS_DIALOG%", $cols_dialog, $file);

          file_put_contents($filename,$file);
          
        }
    }
 }

?>
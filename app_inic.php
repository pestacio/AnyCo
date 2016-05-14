<?php
 /*
  *  @autor      Pedro Estácio <pedro.estacio@quad-systems.com>
  *  @versão     1.0
  *  @revisão    2015.11.07
  *  @copyright  (c) 2015 QuadSystems - http://www.quad-systems.com
  *  @nome	 app_inic.php
  *  @descrição	 inicialização da aplicação
  *  @package 	 Application
  */

    require("app_class_db.php");
    require("app_class_base.php");
    require("app_bd_data.php");

    ##
    ##   PARAMETROS APLICACIONAIS
    ##
    define(APP_URL_DB_CONTROLER,"https://www.wips.com.pt/AnyCo/app_bd_table_controller.php");

    $app_title = "Portal";
    $app_favicon = "data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAQEc2AB0VHwBXXE0ABQMAAGRsgwAuKTkAHBsfAEtFXQANDBAAKjNPACksMQAZGSUASUdHACocPQAzNDMAR0pgAGuUsACPmGkAPkNTABskOAAhHCUAKCU1AJJ3YwBAPlEASE5NAEtNWABcfbAAGyg+ABYZHgCUXZQANDM3AFJZYAA/LDoAKCkzABQXHAB7jJ4AS0V4AB8bIQAyOUgAHhgZABwaPQBwf4EAgZNhAGxvfQBkesIAJiMsABcUHQA7O0sAP0xVACYmLAA0MkwAZGV5AJOtWgBfXGEAMDI8AA4RFgBRUFIAdXO1AHV8iwBzZ50AbIBfAFNMTQArKDgAUFNjADYjTgAiISsAMCtAAIOVdgAzKB8AKSczAJxslgAgICYAKCcrAB4XDgAWGh8AJCQ0ACknPAA7QFAADQoTABkSFQAVFRUAIh04ADRRWwBHS2MAUVecABccKwBYXXIAdlZbAJWISQAeGiAAS1ZdACklKgCVlmQAGhkbAB8eLgAkKyIACQkPACMnHQCAjscAHx0pAH99gwBFSl8AZXSNAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABkAAAAAAAAAAB8AAAAAADRAGgAAAAAAAGFeSwAAAGU7V1QwAAAAAFwvIlYJAAAAOSwFZicAAGJFHCNPAAAAAAANNj5QMQpSYBRKAAAAAAAAAEgTICFBDgspAAAAAAAAAAAACAMlUwwdAAAAAAAAAAAAADwBD00uBgAAAAAAAAAAACQ9Z04zP0ZhAAAAAAAAABIrWFsQGEMWZDgAAAAAAF0XHlUqAAA3TF9aBAAAAEQ1Ry0bAAAAADJCJihRAAAAWToRAAAAAAAABxUCAAAAAABjAAAAAAAAAABJAAAAAAAAAAAAAAAAAAAAAAAAAP//AADv9wAAx+MAAIPBAADBgwAA4AcAAPAPAAD4HwAA+B8AAPAPAADgBwAAwYMAAIPBAADH4wAA7/cAAP//AAA=";
    $page_title = "CRUD Table";
    
    
    ##
    ##   LANGUAGE
    ##
    require("app_lang_pt.php");

?>
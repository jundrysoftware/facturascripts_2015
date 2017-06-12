<?php

/*
 * This file is part of FacturaScripts
 * Copyright (C) 2013-2017  Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/// cargamos las constantes de configuración
require_once 'config.php';
require_once 'base/config2.php';

require_once 'base/fs_db2.php';
$db = new fs_db2();

require_once 'base/fs_model.php';
require_model('fs_extension.php');

if ($db->connect()) {
   if (!filter_input(INPUT_GET, (string)'v')) {
      echo 'Version de la API de FacturaScripts ausente. Actualiza el cliente.';
   } else if (filter_input(INPUT_GET, (string)'v') == '2') {
      if (filter_input(INPUT_GET, (string)'f')) {
         $ejecutada = FALSE;
         $fsext = new fs_extension();
         foreach ($fsext->all_4_type('api') as $ext) {
            if ($ext->text == filter_input(INPUT_GET, (string)'f')) {
               try {
                  filter_input(INPUT_GET, (string)'f')();
               } catch (Exception $e) {
                  echo 'ERROR: ' . $e->getMessage();
               }

               $ejecutada = TRUE;
               break;
            }
         }

         if (!$ejecutada) {
            echo 'Ninguna funcion API ejecutada.';
         }
      } else
         echo 'Ninguna funcion ejecutada.';
   }
   else {
      echo 'Version de la API de FacturaScripts incorrecta. Actualiza el cliente.';
   }
} else
   echo 'ERROR al conectar a la base de datos';

<?php

require_once('database.php');

/**
 * Išvestine klasė skirta valgyklos duomenų bazės duomenims apdoroti
 */
class ValgyklaDB extends Database {

  // Duomenų bazės užklausų masyvas
  private $queryArray = array(
      'addProduct' => 'INSERT INTO produktas ( produkto_pav, mat_vienetai ) VALUES ("%s", %d)',
      'addUser' => 'INSERT INTO vartotojai ( login, slaptazodis, vardas, pavarde, access ) VALUES ("%s", "%s", "%s", "%s", %d)',
      'removeUser' => 'DELETE FROM vartotojai WHERE (idVartotojo=%d)',
      'listUser' => 'SELECT vardas,pavarde, idVartotojo FROM vartotojai',
      'listUserComboBox' => 'SELECT vardas, pavarde, idVartotojo, access FROM vartotojai',
      'addDish' => 'INSERT INTO patiekalai ( patiekalo_pav ) VALUES ("%s")',
      'removeDish' => 'DELETE FROM patiekalai WHERE (patiekalo_nr=%d)',
      'listDishProduct' => 'SELECT produkto_pav, produkto_id FROM produktai_patiekalui, produktas WHERE (patiekalo_nr=%d) AND (produktas_id=produkto_id)',
      'listDishProductTable' => 'SELECT produkto_pav, produkto_id, produktas_kiekis, mat_vnt_pav  FROM produktai_patiekalui JOIN produktas ON produkto_id = produktas_id JOIN matavimo_vnt ON mat_vnt = mat_vienetai WHERE patiekalo_nr = %d',
      'removeDishProduct' => 'DELETE FROM produktai_patiekalui WHERE (patiekalo_nr=%d) AND (produktas_id=%d)',
      'listDishes' => 'SELECT patiekalo_pav, patiekalo_nr FROM patiekalai'
  );

  /**
   * Išvestines klases konstruktorius
   */
  function __destruct() {
    parent::__destruct();
  }

  function addProduct($prodPav, $matVnt) {
    $query = sprintf($this->queryArray['addProduct'], $prodPav, $matVnt);

    $this->query($query);

    echo 'Produktas ' . $prodPav . ' pridėtas.';
  }

  function addUser($login, $pass, $vardas, $pavarde, $level) {
    $query = sprintf($this->queryArray['addUser'], $login, md5($pass), $vardas, $pavarde, $level);
    $this->query($query);
    echo mysql_insert_id();
  }

  function removeUser($id) {
    $query = sprintf($this->queryArray['removeUser'], $id);
    $this->query($query);
    echo 'Virejas pašalintas.';
  }

  function listCook() {
    $query = $this->queryArray['listUser'];
    $this->query($query);
    $htmlkodas = '<TABLE id="virejuSaras"
        summary="Virėjų sąrašas" class="helpT" cellspacing="0">';
    $htmlkodas .= '<thead>
        <TR><TD colspan="4" class="helpHed">Registruoti virėjai</TD></TR>
        <TR>
        <TD class="helpHed">Vardas</TD>
        <TD class="helpHed">Pavardė</TD>
        <TD class="helpHed">Stažas</TD>
        <TD class="helpHed">Asm. Kodas</TD>
        </TR>
        </thead>
        <tbody>';

    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR id="vir' . $row[4] . '"><TD>' . $row[0] . '</TD><TD>' . $row[1] . '</TD><TD>' . $row[2] . '</TD><TD>' . $row[3] . '</TD></TR>';
    }
    $htmlkodas .= '</tbody></TABLE><br>';

    return $htmlkodas;
  }

  function listUserComboBox($id, $boolListbox = false, $size = 5) {
    $htmlkodas = '<SELECT id="' . $id . '">' . "\n";
    if ($boolListbox)
      $htmlkodas = '<SELECT id="' . $id . '" size=' . $size . '">' . "\n";
    $this->query($this->queryArray['listUserComboBox']);
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[2] . '">' . levelToString($row[3]) . ": " . $row[0] . " " . $row[1] . '</OPTION>' . "\n";
    }
    $htmlkodas .= '</SELECT>' . "\n";
    return $htmlkodas;
  }

  function addDish($patiekalo_pav) {
    $query = sprintf('INSERT INTO patiekalai ( patiekalo_pav ) VALUES ("%s")', $patiekalo_pav);

    $this->query($query);
    echo mysql_insert_id();
  }

  function removeDish($patiekalo_ID) {
    $query = sprintf('DELETE FROM patiekalai WHERE (patiekalo_nr=%d)', $patiekalo_ID);
    $this->query($query);
    echo 'Patiekalas pašalintas.';
  }

  function listDishProduct($patiekalas = 0) {
    $query = sprintf('SELECT produkto_pav, produkto_id FROM produktai_patiekalui, produktas WHERE (patiekalo_nr=%d) AND (produktas_id=produkto_id)', $patiekalas);
    $htmlkodas = "";
    $this->query($query);
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[1] . '">' . $row[0] .
              '</OPTION>' . "\n";
    }
    echo $htmlkodas;
  }

  function listDishProductTable($patiekalas = 0) {
    $i = 0;
    $query = sprintf($this->queryArray['listDishProductTable'], $patiekalas);
    $htmlkodas = "";
    $this->query($query);
    $htmlkodas .= '<thead>
        <TR><TD class="ui-state-default" colspan="4" id="tbl-ppd-title"></TD></TR>
        <TR>
        <TD class="ui-state-default">#</TD>
        <TD class="ui-state-default">Patiekalo ingridientas</TD>
        <TD class="ui-state-default">Reikalingas kiekis</TD>
        <TD class="ui-state-default">Mat. vnt.</TD>
        </TR>
        </thead>
        <tbody>';

    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR><TD><input type="radio" class="selPPD' . ++$i . '" value="' . $row[1] . '" name="selPPD"/><TD>' . $row[0] . '</TD><TD>' . round($row[2], 3, PHP_ROUND_HALF_UP) . '</TD><TD>' . $row[3] . '</TD></TR>';
    }
    $htmlkodas .='</tbody>';
    echo $htmlkodas;
  }

  function listConsumedProductsTable($name, $data=null) {
    DEBUG_OUT($data);
    if (!$data)
      $query = sprintf("SELECT produkto_pav, sum(kiekis), data,mat_vnt_pav FROM sanaudos
                          JOIN produktas ON produkto_id = pid
                          JOIN matavimo_vnt ON mat_vienetai = mat_vnt
                          GROUP BY pid, data");
    else
      $query = sprintf("SELECT produkto_pav, sum(kiekis), data, mat_vnt_pav FROM sanaudos
                          JOIN produktas ON produkto_id = pid
                          JOIN matavimo_vnt ON mat_vienetai = mat_vnt
                          WHERE data='%s' GROUP BY pid, data", $data);


    $htmlkodas = '<thead>
      <TR><TD class="ui-state-default" colspan="4" id="' . $name . '">Produktų sąnaudos</TD></TR>
      <TR>
      <TD class="ui-state-default">Produktas</TD>
      <TD class="ui-state-default">Kiekis</TD>
      <TD class="ui-state-default">Mat. vnt.</TD>
      <TD class="ui-state-default">Data</TD>
      </TR>
      </thead>
      <tbody>';
    $this->query($query);
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR><TD>' . $row[0] . '</TD><TD>' . $row[1] . '</TD><TD>' . $row[3] . '</TD><TD>' . $row[2] . '</TD></TR>' . "\n";
    }
    $htmlkodas .= '</tbody>';
    echo $htmlkodas;
  }

  function removeDishProduct($patiekalas, $produktas) {
    $query = sprintf('DELETE FROM produktai_patiekalui WHERE (patiekalo_nr=%d)AND (produktas_id=%d)', $patiekalas, $produktas);
    $this->query($query);
    echo 'Produktas pašalintas.';
  }

  function listDishes($name) {
    $htmlkodas = "<SELECT id=\"$name\" \n";
    $htmlkodas .= '<OPTION value="0">Pasirinkite</OPTION>' . "\n";
    $this->query($this->queryArray['listDishes']);
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[1] . '">' . $row[0] .
              '</OPTION>' . "\n";
    }
    $htmlkodas .= '</SELECT>' . "\n";
    return $htmlkodas;
  }

  function listDishesTable() {
    $this->query($this->queryArray['listDishes']);
    $htmlkodas = '';
    $htmlkodas .= '<thead>
    		<TR>
    		<TD class="helpHed">Patiekalas</TD>
    		<TD class="helpHed">Šalinti</TD>
    		</TR>
    		</thead>
    		<tbody>';
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR><TD>' . $row[0] . '</TD>' . "\n" .
              '<TD><button class="salinti"></button></TD></TR>' . "\n";
    }
    $htmlkodas .= '</tbody>';
    return $htmlkodas;
  }

  function arrayProduct() {
    $this->query('SELECT produkto_pav, produkto_id, mat_vnt_pav FROM produktas JOIN matavimo_vnt ON mat_vienetai = mat_vnt');
  }

  function listProduct($name) {
    $htmlkodas = '<SELECT id="' . $name . '" size="7" style="width:100px">' . "\n";
    $this->arrayProduct();

    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[1] . '">' . $row[0] .
              '</OPTION>' . "\n";
    }
    $htmlkodas .= '</SELECT>' . "\n";
    return $htmlkodas;
  }

  function listProductAlt($name) {
    $htmlkodas = '<SELECT id="' . $name . '" style="width:200px">' . "\n";
    $this->arrayProduct();

    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[1] . '">' . $row[0] . ' (vnt:' . $row[2] .
              ')</OPTION>' . "\n";
    }
    $htmlkodas .= '</SELECT>' . "\n";
    return $htmlkodas;
  }

  function listUnit($id, $boolListbox = false, $size = 5) {
    $htmlkodas = '<SELECT id="' . $id . '">' . "\n";
    if ($boolListbox)
      $htmlkodas = '<SELECT id="' . $id . '" size=' . $size . '">' . "\n";
    $this->query('SELECT mat_vnt_pav, mat_vnt FROM matavimo_vnt');
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<OPTION value="' . $row[1] . '">' . $row[0] .
              '</OPTION>' . "\n";
    }
    $htmlkodas .= '</SELECT>' . "\n";
    return $htmlkodas;
  }

  function updateProduct($produktas, $matID) {
    $query = sprintf('UPDATE produktas SET mat_vienetai=%d WHERE (produkto_pav="%s")', $matID, $produktas);
    $this->query($query);
    echo 'Produkto matavimo vienetai pakeisti.';
  }

  function addDishProduct($produktas, $patiekalas, $kiekis) {
    $query = sprintf('INSERT INTO produktai_patiekalui ( produktas_ID, patiekalo_nr, produktas_kiekis ) VALUES (%d, %d, %f)', $produktas, $patiekalas, $kiekis);

    $this->query($query);
  }

  function removeProduct($produktas) {
    $query = sprintf('DELETE FROM produktas WHERE (produkto_id=%d)', $produktas);
    $this->query($query);
  }

  function addWarehouseProduct($produktas, $kiekis) {
    $query = sprintf('UPDATE produktas SET kiekis_sand=%f WHERE (produkto_id=%d)', $kiekis, $produktas);

    $this->query($query);
    echo $this->listWarehouseProduct();
  }

  function removeProduction($id) {
    $query = sprintf('DELETE FROM gamyba WHERE (idGamyba=%d)', $id);
    $this->query($query);
  }
  
  function addWarehouseProductAlt($produktas, $kiekis, $data) {
    $query = sprintf('INSERT INTO sandelys ( pid, produkto_kiekis, galiojimo_data ) VALUES (%d, %f, \'%s\')', $produktas, $kiekis, $data);

    $this->query($query);
  }

  function listWarehouseProduct() {
    $i = 0;
    $this->query('SELECT produkto_pav, pid, produkto_kiekis, galiojimo_data, produkto_id,mat_vnt_pav, idSand FROM produktas, matavimo_vnt, sandelys WHERE (mat_vienetai=mat_vnt AND produkto_id = pid ) ORDER BY produkto_pav');
    $htmlkodas = '
        <thead>
        <TR><TD colspan="5" class="ui-state-default">Produktai sandėlyje</TD></TR>
        <TR>
        <TD class="ui-state-default">#</TD>
        <TD class="ui-state-default">Produktas</TD>
        <TD class="ui-state-default">Kiekis</TD>
        <TD class="ui-state-default">Mat. vnt.</TD>
        <TD class="ui-state-default">Galiojimo data</TD>
        </TR>
        </thead>
        <tbody>';

    while ($row = $this->fetchRow()) {
      $query = sprintf('SELECT patiekalo_pav, produktas_kiekis FROM produktai_patiekalui
                            JOIN patiekalai ON patiekalai.patiekalo_nr = produktai_patiekalui.patiekalo_nr
                            WHERE produktas_id=%d', $row[4]);
      $res2 = mysql_query($query, $this->_con);
      $kitiPat = "Naudojamas:<br>\n";
      while ($row2 = $this->fetchRowRes($res2)) {

        $kitiPat .= $row2[0] . " " . round($row2[1], 2, PHP_ROUND_HALF_UP) . "<br>\n";
      }
      $htmlkodas .= '<TR title="' . $kitiPat . '" style="background-color:' . validDateToColor($row[3]) . ';"><TD><input type="radio" class="selWh' . ++$i . '" value="' . $row[6] . '" name="selWh"/></TD><TD>' . $row[0] . '</TD><TD>' . round($row[2], 3, PHP_ROUND_HALF_UP) . '</TD><TD>' . $row[5] . '</TD><TD>' . $row[3] . '</TD></TR>';
    }
    $htmlkodas .= '</tbody>';
    return $htmlkodas;
  }

  function addProduction($patiekalas, $virejas, $kiekis, $date) {
    $cantMake = false;
    $tmpArray1 = array();
    $tmpArray2 = array();
    $query = sprintf('SELECT (produktas_kiekis*%d),(SELECT sum(produkto_kiekis) FROM sandelys WHERE pid = produktas_id AND galiojimo_data >= \'$date\'),produktas_id, produkto_pav, patiekalo_pav
                          FROM produktai_patiekalui
                          JOIN produktas ON produkto_id = produktas_id
                          JOIN patiekalai ON produktai_patiekalui.patiekalo_nr = patiekalai.patiekalo_nr
                          WHERE produktai_patiekalui.patiekalo_nr  = %d ', $kiekis, $patiekalas);

    $this->query($query);
    $message = '<b>';
    while ($row = $this->fetchRow()) {
      if (!$row[1] || ($row[1] - $row[0]) < 0) {
        $message .= ( $row[3] . '(' . -($row[1] - $row[0]) . ') ');
        $cantMake = true;
      } else {
        $tmpArray1[] = $row[2];
        $tmpArray2[] = $row[0];
      }
    }
    $message .='</b>';
    if ($cantMake) {
      echo 'Nepakanka ' . $message . ' norint pagaminti norima patiekalo kiekį.';
      return;
    }
    $query = sprintf("INSERT INTO gamyba (patiekalas, virejas, kiekis,data) VALUES(%d, %d, %d, '%s')", $patiekalas, $virejas, $kiekis, $date);

    $this->query($query);
    $lastID = mysql_insert_id();
    for ($i = 0; $i < count($tmpArray1); $i++) {
      $query = sprintf("INSERT INTO sanaudos ( pid, kiekis, data, gid ) VALUES( %d, %f, '%s', %d)", $tmpArray1[$i], $tmpArray2[$i], $date, $lastID);
      $this->query($query);
      $this->subtractWarehouseProduct($tmpArray1[$i], $tmpArray2[$i]);
    }

  
  }

  function subtractWarehouseProduct($produktas, $kiekis) {
    $tmp = 0;
    $query = sprintf('SELECT produkto_kiekis, idSand FROM sandelys WHERE pid = %d AND galiojimo_data >= CURDATE() ORDER BY galiojimo_data ASC LIMIT 1', $produktas);
    $res = mysql_query($query, $this->_con);

    while ($row = $this->fetchRowRes($res)) {
      if ($row[0] - $kiekis == 0) {
        $query = sprintf('DELETE FROM sandelys WHERE (idSand=%d)', $row[1]);
        $res1 = mysql_query($query, $this->_con);
      } else if ($row[0] - $kiekis < 0) {
        $tmp = $kiekis - $row[0];
        $query = sprintf('DELETE FROM sandelys WHERE (idSand=%d)', $row[1]);
        $res1 = mysql_query($query, $this->_con);
        $this->subtractWarehouseProduct($produktas, $tmp);
      } else {
        $tmp = $row[0] - $kiekis;
        $query = sprintf('UPDATE sandelys SET produkto_kiekis=%f WHERE idSand=%d', $tmp, $row[1]);
        $res1 = mysql_query($query, $this->_con);
        return;
      }
    }
  }

  function listProduction() {
    $i = 0;
    $query = sprintf('SELECT patiekalo_pav, vardas, pavarde, kiekis, data, idGamyba
						  FROM gamyba LEFT JOIN(patiekalai, vartotojai)
						  ON (gamyba.patiekalas=patiekalai.patiekalo_nr AND gamyba.virejas=vartotojai.idVartotojo)');
    $this->query($query);
    $htmlkodas = '';
    $htmlkodas .= '<thead>
        <TR>
        <TD colspan="5" class="ui-state-default" id="tbl-prod-title">Gaminami patiekalai</TD>
        </TR>
        <TR>
        <TD class="ui-state-default">#</TD>
        <TD class="ui-state-default">Patiekalas</TD>
        <TD class="ui-state-default">Virėjas</TD>
        <TD class="ui-state-default">Kiekis(porc.)</TD>
        <TD class="ui-state-default">Data</TD>
        </TR>
        </thead>
        <tbody>';
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR><TD><input type="radio" class="selPD' . ++$i . '" value="' . $row[5] . '" name="selPD"/></TD><TD>' . $row[0] . '</TD><TD>' . $row[1] . ' ' . $row[2] . '</TD><TD>' . $row[3] . '</TD><TD>' . $row[4] . '</TD></TR>';
    }
    $htmlkodas .= '</tbody>';
    echo $htmlkodas;
  }

  function removeWarehouseProduct($prod) {
    $query = sprintf('DELETE FROM sandelys WHERE (idSand=%d)', $prod);
    $this->query($query);
  }

  function listProductionAlt($date) {
    $i = 0;
    $query = sprintf('SELECT patiekalo_pav, vardas, pavarde, kiekis, data, idGamyba
						  FROM gamyba LEFT JOIN(patiekalai, vartotojai)
						  ON (gamyba.patiekalas=patiekalai.patiekalo_nr AND gamyba.virejas=vartotojai.idVartotojo) WHERE data=\'%s\'', $date);
    $this->query($query);
    $htmlkodas = '';
    $htmlkodas .= '<thead>
        <TR>
        <TD colspan="5" class="ui-state-default" id="tbl-prod-title">Gaminami patiekalai</TD>
        </TR>
    		<TR>
        <TD class="ui-state-default">#</TD>
        <TD class="ui-state-default">Patiekalas</TD>
        <TD class="ui-state-default">Virėjas</TD>
        <TD class="ui-state-default">Kiekis(porc.)</TD>
        <TD class="ui-state-default">Data</TD>
    		</TR>
    		</thead>
    		<tbody>';
    while ($row = $this->fetchRow()) {
      $htmlkodas .= '<TR><TD><input type="radio" class="selPD' . ++$i . '" value="' . $row[5] . '" name="selPD"/></TD><TD>' . $row[0] . '</TD><TD>' . $row[1] . ' ' . $row[2] . '</TD><TD>' . $row[3] . '</TD><TD>' . $row[4] . '</TD></TR>';
    }
    $htmlkodas .= '</tbody>';
    echo $htmlkodas;
  }

}

function filter_POST_GET($var) {
  return htmlentities($var, ENT_QUOTES, 'UTF-8');
}

function DEBUG_OUT($str) {
  $file = fopen('debug.txt', 'a+');
  fwrite($file, $str);
  fclose($file);
}

function validDateToColor($str) {
  $date = strtotime($str);
  $delta = $date - time();
  if ($delta < 0)
    return '#FF245A';
  else if ($delta < 24 * 60 * 60)
    return '#FC7798';
  else if ($delta < 3 * 24 * 60 * 60)
    return '#FFC4D3';
  else
    return '#FFFFF';
}

function validDateToText($str) {
  $date = strtotime($str);
  $delta = $date - time();
  if ($delta < 0)
    return 'Produkto galiojimo laikas pasibaigęs';
  else if ($delta < 24 * 60 * 60)
    return 'Produkto galiojimo laikas baigsis už vienos dienos';
  else if ($delta < 3 * 24 * 60 * 60)
    return 'Produkto galiojimo laikas neužilgo baigsis';
  else
    return 'Šviežias';
}

function levelToString($level) {
  switch($level)
  {
    case 1:
      return "Virėjas";
      break;
    case 2:
      return "Vadybininkas";
      break;
  }
}
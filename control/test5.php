<?php
  // Déclaration de la matrice
  $matrice = array();
  $matrice[0] = array('X','O','X');
  $matrice[1] = array('X','X','O');
  $matrice[2] = array('X','O','O');
  echo json_encode($matrice);
?>
<?php
  class Datatables_model_query extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();
    }

    public function generate($table, $columns, $index, $joins, $where, $search, $groupby)
    {

      $sLimit = $this->get_paging();
      $sOrder = $this->get_ordering($columns);
      $sWhere = $this->get_filtering($columns,$where,$search);
      $rResult = $this->get_display_data($table, $columns, $sWhere, $sOrder, $sLimit, $joins, $groupby);
      $rResultFilterTotal = $this->get_data_set_length();
      $aResultFilterTotal = $rResultFilterTotal->result_array();
      $iFilteredTotal = $aResultFilterTotal[0]["FOUND_ROWS()"];
      $rResultTotal = $this->get_total_data_set_length($table, $index, $sWhere, $joins, $where, $groupby, $columns);
      if ($groupby=="")
      {
         $aResultTotal = $rResultTotal->result_array();
         $iTotal = $aResultTotal[0]["COUNT($index)"];
      }
      else {
             $iTotal = strval($rResultTotal);
           }
      $DatoSalida = $this->produce_output($columns, $iTotal, $iFilteredTotal, $rResult);
      return $DatoSalida;
    }

    protected function get_paging()
    {
      $sLimit = "";

      if($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1")
        $sLimit = "LIMIT " . $this->input->post("iDisplayStart") . ", " . $this->input->post("iDisplayLength");
      else
      {
        $sLimit = "LIMIT " . "0" . ", " . $this->input->post("iDisplayLength");
      }

      return $sLimit;
    }

    protected function get_ordering($columns)
    {
      $sOrder = "";

      if($this->input->post("iSortCol_0"))
      {
        $sOrder = "ORDER BY ";

        for($i = 0; $i < intval($this->input->post("iSortingCols")); $i++)
          $sOrder .= $columns[intval($this->input->post("iSortCol_" . $i))] . " " . $this->input->post("sSortDir_" . $i) . ", ";

        $sOrder = substr_replace($sOrder, "", -2);
      }

      return $sOrder;
    }

    protected function get_filtering($columns, $where, $search)
    {
      $sWhere="";
      $TieneParentesis=0;
      if ($where!="")
      {
         $sWhere = "WHERE ".$where;
      }
      

      if($this->input->post("sSearch") != "")
      {

        if ($sWhere!="")
        {
            $sWhere.=" AND (";
            $TieneParentesis=1;
        }

        for($i = 0; $i < count($columns); $i++)
          $sWhere .= $columns[$i] . " LIKE '%" . $this->input->post("sSearch") . "%' OR ";

        $sWhere = substr_replace($sWhere, "", -3);
        if ($TieneParentesis==1)
            $sWhere.=")";
      }

      return $sWhere;
    }

    protected function get_display_data($table, $columns, $sWhere, $sOrder, $sLimit, $joins, $groupby)
    {
      $Consulta = " SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . " FROM $table $joins $sWhere $groupby $sOrder $sLimit ";
      $DatoSalida = $this->db->query($Consulta);
      return $DatoSalida;
    }

    protected function get_data_set_length()
    {
      $DatoSalida = $this->db->query("SELECT FOUND_ROWS()");
      return $DatoSalida;
    }

    protected function get_total_data_set_length($table, $index, $sWhere,$joins, $where, $groupby, $columns)
    {

      if ($groupby=="")
      {
          $Consulta = "SELECT COUNT(" . $index . ") FROM $table $joins $sWhere ";
          $DatoSalida = $this->db->query($Consulta);
      }
      else
      {
          $ConsultaSql = "SELECT " . implode(", ", $columns) . " FROM $table $joins $sWhere $groupby ";
          $Consulta = $this->db->query($ConsultaSql);
          $DatoSalida = $Consulta->num_rows();
      }
      return $DatoSalida;
    }

    protected function produce_output($columns, $iTotal, $iFilteredTotal, $rResult)
    {
      $aaData = array();

      foreach($rResult->result_array() as $row_key => $row_val)
      {
        foreach($row_val as $col_key => $col_val)
        {
          if($row_val[$col_key] == "version")
            $aaData[$row_key][$col_key] = ($aaData[$row_key][$col_key] == 0)? "-" : $col_val;
          else
          {
            switch($row_val[$col_key])
            {
              default: $aaData[$row_key][] = $col_val; break;
            }
          }
        }
      }

      $sOutput = array
      (
        "sEcho"                => intval($this->input->post("sEcho")),
        "iTotalRecords"        => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData"               => $aaData
      );

      return json_encode($sOutput);
    }
  }
?>
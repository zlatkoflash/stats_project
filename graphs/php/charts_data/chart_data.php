<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ChartData extends DataModerator
{
    const GROUP_A="A";
    const GROUP_B="B";
    

    public function ChartData()
    {
    }
    
    /*
     * functions for init and clausule for MySQL selecting
     * It depend from a lot of variables
     */
    const AREA_ATINA_SOLUN   = "atina_solun";
    const AREA_REST_OF_STATE = "eparhija";
    
    public function SQLforAND_area($areaID) {
        if ($areaID != "-1") {
            $areaANDClausule = " Area='" . $areaID . "' ";
        } else {
            $areaANDClausule = " Area<>'-1' ";
        }
        if ($areaID == self::AREA_ATINA_SOLUN) {
            $areaANDClausule = " (Area='1' OR Area='2') ";
        } else if ($areaID == self::AREA_REST_OF_STATE) {
            $areaANDClausule = " Area<>'1' AND Area<>'2' ";
        }
        return $areaANDClausule;
    }

    public function SQLforAND_chain($chainID) {
        if ($chainID != "-1") {
            $chainANDClausule = " Chains='" . $chainID . "' ";
        } else {
            $chainANDClausule = " Chains<>'-1' ";
        }
        return $chainANDClausule;
    }

    public function SQLforAND_dealer($dealerID) {
        if ($dealerID != "-1") {
            $delearANDClausule = " dealerCode='" . $dealerID . "' ";
        } else {
            $delearANDClausule = " dealerCode<>'-1' ";
        }
        return $delearANDClausule;
    }

    public function SQLforAND_year($yearFromOut) {
        if ($yearFromOut != "-1") {
            $yearANDClausule = " Year='" . $yearFromOut . "' ";
        } else {
            $yearANDClausule = " Year<>'-1' ";
        }
        return $yearANDClausule;
    }
    public function MONTHs_OR_CLAUSULE($months) {
        if ($months == "-1") {
            $months = "1,2,3,4,5,6,7,8,9,10,11,12";
        }
        $monthsARR = explode(",", $months);
        $sqlClaus = " ( ";
        for ($i = 0; $i < count($monthsARR); $i++) {
            $sqlClaus .= "Months='" . $monthsARR[$i] . "'";
            if ($i < count($monthsARR) - 1) {
                $sqlClaus .= " OR ";
            }
        }
        $sqlClaus .= " ) ";
        return $sqlClaus;
    }
    protected $area_year_month_dealercode_chain__SQL_condition;
    protected function area_year_month_dealercode_chain__SQL_condition_init( $group_type )
    {
        $this->area_year_month_dealercode_chain__SQL_condition = 
                $this->SQLforAND_area( $_POST["areas_options__".$group_type] )." AND ".
                $this->SQLforAND_year( $_POST["years_options__".$group_type] )." AND ".
                $this->MONTHs_OR_CLAUSULE( $_POST["months_periods_options__".$group_type] )." AND ".
                $this->SQLforAND_dealer( $_POST["dealers_options__".$group_type] )." AND ".
                $this->SQLforAND_chain( $_POST["chains_options__".$group_type] );
    }
    
    /*
     * Quanity XML line, for colum from data, with total count of the variables
     * selected by value "get_quantity"
     * and
     * selected by total count "get_quantity_total"
     */
    protected function get_quantity_xml_line( $column_variable, $value_column )
    {
        $sql_select_quantity = "SELECT COUNT(".$column_variable.") AS ___COUNT___ FROM data WHERE " . 
                $this->area_year_month_dealercode_chain__SQL_condition . " AND ".$column_variable."='".$value_column."'";
        //print $sql_select_quantity;
        $quantity = DB_DETAILS::ADD_ACTION($sql_select_quantity, DB_DETAILS::$TYPE_SELECT);
        return "<".$column_variable.">".$quantity[0]["___COUNT___"]."</".$column_variable.">";
    }
    protected function get_quantity_total_xml_line( $column_variable )
    {
        $sql_select_quantity_total = "SELECT COUNT(".$column_variable.") AS ___COUNT___ FROM data WHERE ".
                $this->area_year_month_dealercode_chain__SQL_condition;
        $quantity = DB_DETAILS::ADD_ACTION($sql_select_quantity_total, DB_DETAILS::$TYPE_SELECT);
        return "<".$column_variable.">".$quantity[0]["___COUNT___"]."</".$column_variable.">";
    }
    protected function get_quantity_xml_data_for_array($array_variables, $xml_data_holder_name="quantity")
    {
        $data_quantity = "<".$xml_data_holder_name.">";
        $data_quantity .= "<quantity>";
        for($i=0;$i<count($array_variables);$i++)
        {
            $data_quantity .= $this->get_quantity_xml_line($array_variables[$i]["column"], $array_variables[$i]["value"]);
        }
        $data_quantity .= "</quantity>";
        $data_quantity .= "<quantity_total>";
        for($i=0;$i<count($array_variables);$i++)
        {
            $data_quantity .= $this->get_quantity_total_xml_line($array_variables[$i]["column"]);
        }
        $data_quantity .= "</quantity_total>";
        $data_quantity .= "</".$xml_data_holder_name.">";
        return $data_quantity;
    }

    /*
     * function for sending the variables XML back to client
     * It is using in constructor of each data moderator for charts
     */
    protected function print_back_to_client()
    {
        /*
        DB_DETAILS::$VARs["data"] = $this->data_xml_total;
        DB_DETAILS::PRINT_VARS();*/
        print $this->data_xml_total;
    }

    /*
     * All years for filter
     */
    public static $all_years;
    public static function init_all_years()
    {
        self::$all_years = 
        DB_DETAILS::ADD_ACTION("SELECT DISTINCT(Year) FROM data ORDER BY Year", DB_DETAILS::$TYPE_SELECT);
    }
    
    /*
     * All months periods
     */
    public static $all_months_periods;
    public static function init_all_months_periods()
    {
        self::$all_months_periods = 
        DB_DETAILS::ADD_ACTION("SELECT * FROM months", DB_DETAILS::$TYPE_SELECT);
    }
}
?>

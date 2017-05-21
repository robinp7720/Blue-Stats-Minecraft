<?php
/* Author: Johan Hanssen Seferidis
 *
 * Description:
 *    A simple dynamic table class. You don't have to specify the table's size.
 *    The table grows automatically on need.
 *
 * Created: 2013-03-25
 * Updated: 2013-12-29
 *
 * Table visually:
 *
 *           x0   x1        xn      x-axis
 *         +----+----+ .. +----+
 *     y0  |    |    |    |    |
 *         +----+----+ .. +----+
 *     y1  |    |    |    |    |
 *         +----+----+ .. +----+
 *         :    :    :    :    :
 *         +----+----+----+----+
 *     yn  |    |    |    |    |
 *         +----+----+----+----+
 *
 *   y-axis
 *
 *   X = whole row
 *   Y = whole column
 *
 *
 * */

class Table
{

    private $header;       // the table's header
    private $data;         // the actual table's data
    private $classesCells; // the classes of columns
    private $classesRows;  // the classes of rows
    private $biggestRow;   // number of cells of the longest row
    public function __construct() {
        $this->data=array();
        $this->header=array();

        $this->classesCells=array();
        $this->classesRows=array();

        $this->biggestRow=0;
    }


    /* Add/change header of table
     *
     * Takes: Variable number of strings
     *
     * */
    public function makeHeader(){
        $this->header=func_get_args();

        // Check if biggestRow should be updated
        $rowLength=func_num_args();
        if ($rowLength>$this->biggestRow)
            $this->biggestRow=$rowLength;
    }


    /* Add a record to the table
     *
     * Takes: Variable number of strings
     *
     * */
    public function addRecord(){
        $row=func_get_args();
        $this->data[]=$row;

        // Check if biggestRow should be updated
        $rowLength=count($row);
        if ($rowLength>$this->biggestRow)
            $this->biggestRow=$rowLength;
    }


    /* Add classes to all cells on specific column
     *
     * Takes: Class name
     *        Column number
     *
     * */
    public function addClassX($classname, $x){
        $rowsN=count($this->data);
        for ($i=0; $i<$rowsN; $i++){
            $this->classesCells[$i][$x]=$classname;
        }
    }
    /* Add classes to every n-th row
     *
     * Takes: Class name
     *        Every n row
     *        Starting row position
     *
     * */
    public function addClassRowEvery($classname, $n, $startingRow){
        for ($i=$startingRow; $i<count($this->data); $i+=$n){
            $this->classesRows[$i]=$classname;
        }
    }


    /* Print the table in raw format with all variables etc.
     *
     * */
    public function showTableInfo() {
        echo '<pre>';
        echo '<b>Number of cells in longest row:</b><br />';
        echo $this->biggestRow . '<br />';
        echo '<br /><b>Header:</b><br />';
        print_r($this->header);
        echo '<br /><b>Data:</b><br />';
        print_r($this->data);
        echo '<br /><b>Row classes:</b><br />';
        print_r($this->classesRows);
        echo '<br /><b>Cell classes:</b><br />';
        print_r($this->classesCells);
        echo '</pre>';
    }

    /* Convert table to HTML code
     *
     * Gives: string with formatted table in HTML
     *
     * */
    public function tableToHTML() {
        $cellsY=count($this->data);
        $cellsX=$this->biggestRow;
        $string="<table class='table table-sorted'>\n";
        // th case
        if (!empty($this->header)) {
            $header=$this->header;
            $string.="\t<thead><tr>\n";
            for ($i=0; $i<$cellsX; $i++){
                $string.="\t\t<th>";
                if (isset($header[$i]))
                    $string.=$header[$i];
                $string.="</th>\n";
            }
            $string.="\t</tr></thead>\n";
        }
        // td case
        $rowNumber=0;
        foreach($this->data as $row){ // per row
            $string.="\t<tr";
            // Add row classes
            if (!empty($this->classesRows))
            {
                if (!empty($this->classesRows[$rowNumber])) // add row class
                    $string.=" class='" . $this->classesRows[$rowNumber] . "'";
                if ($rowNumber<($cellsY-1))
                    $rowNumber++;
            }
            $string.=">\n";

            for ($i=0; $i<$cellsX; $i++) // per cell
            {
                $string.="\t\t<td";

                // Add cell classes
                if (!empty($this->classesCells))
                    if (!empty($this->classesCells[$rowNumber][$i])) // add cell class
                        $string.=" class='" . $this->classesCells[$rowNumber][$i] . "'";
                $string.=">";
                if (isset($row[$i]))
                    $string.=$row[$i];
                $string.="</td>\n";
            }
            $string.="\t</tr>\n";
        }

        $string.='</table>';
        return $string;
    }

    /* ------------------------- SETTERS & GETTERS -------------------------------*/

    /* Get length of longest row
     *
     * */
    public function getXlength() {
        return $this->biggestRow;
    }
}
?>
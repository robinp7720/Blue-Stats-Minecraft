<?php

/**
 * Created by PhpStorm.
 * User: robin
 * Date: 3/3/17
 * Time: 11:50 AM
 */
class chart {


    private $type;
    private $labels = [];
    private $data   = [];

    /**
     * @return string
     */
    public function getType () {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType ($type) {
        $this->type = $type;
    }

    /**
     * @param String $labels
     */
    public function addLabel ($labels) {
        array_push($this->labels, $labels);
    }

    /**
     * @param String $label
     * @param array  $data
     */
    public function addData ($label, $data) {

        $this->data[$label] = $data;
    }

    public function render () {
        if ($this->type == 'bar')
            return $this->renderBar();
        if ($this->type == 'pie')
            return $this->renderPie();

        return FALSE;
    }

    public function renderBar () {
        $values = [];
        foreach ($this->labels as $label) {
            array_push($values, $this->data[$label]);
        }
        $id = uniqid();

        $labelsJson = json_encode($this->labels);
        $seriesJson = json_encode($values);

        return
            "<div id=\"a$id\"></div>
            <script>
                new Chartist.Bar('#a$id', {
                    labels: $labelsJson,
                    series: [$seriesJson]
                });
            </script>";
    }

    public function renderPie () {
        $values = [];
        foreach ($this->labels as $label) {
            array_push($values, $this->data[$label]);
        }
        $id = uniqid();

        $labelsJson = json_encode($this->labels);
        $seriesJson = json_encode($values);

        return
            "<div id=\"a$id\"></div>
            <script>
                new Chartist.Pie('#a$id', {
                    labels: $labelsJson,
                    series: $seriesJson
                });
            </script>";
    }


}
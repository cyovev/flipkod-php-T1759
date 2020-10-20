<?php
class Triangle extends AppModel {

    private $sideA,
            $sideB,
            $sideC;

    //////////////////////////////////////////////////////////////////////
    function __construct($a, $b, $c) {
        $this->sideA      = (float) $a;
        $this->sideB      = (float) $b;
        $this->sideC      = (float) $c;
        $areParamsInvalid = (bool)  ($this->sideA == 0
                                  || $this->sideB == 0
                                  || $this->sideC == 0); // if any of the sides are 0, they are invalid

        if ($areParamsInvalid) {
            throw new Exception("Invalid sides");
        }
    }

    //////////////////////////////////////////////////////////////////////
    // there is a getRadius method because on construction the sides
    // get casted to float which may result in different values for them
    public function getSides() {
        return [
            $this->sideA,
            $this->sideB,
            $this->sideC,
        ];
    }

    //////////////////////////////////////////////////////////////////////
    public function calculateCircumference() {
        $circumference = $this->sideA + $this->sideB + $this->sideC;
        return $circumference;
    }

    //////////////////////////////////////////////////////////////////////
    // using heron's formula: surface = sqrt(s * (s-a) * (s-b) * (s-c) ),
    // where s is the semi-perimeter of the triangle
    public function calculateSurface() {
        $semiPerimeter = ($this->sideA + $this->sideB + $this->sideC) / 2;
        $surface       = sqrt(
            $semiPerimeter
            * ($semiPerimeter - $this->sideA)
            * ($semiPerimeter - $this->sideB)
            * ($semiPerimeter - $this->sideC)
        );
        return $surface;
    }

}
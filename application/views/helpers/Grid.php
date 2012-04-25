<?php
class Zend_View_Helper_Grid extends Zend_View_Helper_Abstract
{   
    protected $tb;
    
    public function grid ( $data , $coluns, $attrs=null ) {
        if ( is_object( $data )  && ! empty( $coluns ) ) {
            if ( ! empty( $attrs ) && is_array( $attrs ) ) {
                $attributes = '';
                foreach ( $attrs as $attr => $values ) {
                    $attributes .= $attr .'="'. $values .'" ';
                }
                $this->tb = "<table ". $attributes .">";
            } else {
                $this->tb = "<table>";
            }
            $this->tb .= "<tr>";
            //Headers
            foreach ( $coluns as $nomes ) {
                $this->tb .= "<th>". $nomes ."</th>";
            }
            $this->tb .= "</tr>";
            //Itens
            foreach ( $data as $fields ){
                $this->tb .= "<tr>";
                foreach ( $coluns as $nomes ) {
                    $this->tb .= "<td><a href='admin/editar/id/". $fields['id'] ."'>". $fields[ $nomes ] ."</a></td>";
                }                       
                $this->tb .= "</tr>";
            }
            $this->tb .= "</table>";
            echo $this->tb;
        } else {
            echo "O primeiro e o segundo argumento são obrigatórios. O primeiro argumento deve ser um objeto e o segundo um array";
        }
    }
}

<?php

class Reporter_View_Helper_IsLoggedIn
{
        public function IsLoggedIn($baseUrl='')
        {
                $identity = Zend_Auth::getInstance()->getIdentity();
                #Zend_Debug::Dump($identity);   
                $output = "<div id=\"logged-in\">";

                if($identity)
                {
                $output .= 'conectado como <b>';
                $output .= "{$identity->firstname} {$identity->lastname}";
                $output .= "</b> :: <a href=\"{$baseUrl}/Auth/logout\">sair</a>\n";
                }
                else
                {
                $output .= "<a href=\"{$baseUrl}/Auth/login\">entrar</a>\n";
                }
                $output .= "</div>\n";

                return $output;
        }
}


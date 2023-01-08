<?php
/*
Funksjonene krypter() og dekrypter():

Tekst krypteres og dekrypteres gjennom å skifte ut hvert tegn i stringen med
et tegn fra ASCII fra 32 til 126 - begrenset for å sikre lesbare tegn. 

$endring øker tegnets nummer for hvert tegn som krypteres/dekrypteres - forsterker krypteringen.
 
Dekryptering gjør det motsatte av krypteringsfunksjonen for hvert tegn, slik at vi kommer tilbake
til den opprinnelige teksten. 
*/

function krypter($string)
{
$endring = 7;                   //Endring som skal gjøres.
$string = str_split($string);   //Gjør stringen om til matrise.

    if(!empty($string))
    {
        $matrise= array(); //Matrise for krypterte tegn. 

            foreach($string as $index => $tegn) //Foreach-løkke går gjennom hvert tegn i matrisen. 
            {
                $matrise[$index] = (int) ord($tegn) + $endring++; //Konverterer tegn til nummer, og finner nytt nummer til tegn.

                //Sikrer at vi får et lesbart tegn.
                if($matrise[$index] > 222)
                {
                   $matrise[$index] -= 189;

                } 
                elseif($matrise[$index] > 127)
                {
                   $matrise[$index] -= 94;
                }

                   $matrise[$index] = chr($matrise[$index]);   //Finner ASCII tegn. 
            }
            return implode($matrise); //Matrisen returneres som en string. 
    }
                else
                {
                    echo "Skriv inn tekst.";
                }
            return NULL;
}


function dekrypter($string)
{
    $string = str_split($string);   //Gjør stringen om til matrise.
    $endring = -7;                  //Reverserer endringen som ble gjort i krypter funksjonen. 

    if(!empty($string))
    {
        $matrise = array(); //Matrise med krypterte tegn. 

        foreach($string as $index => $tegn) //Foreach-løkke går gjennom hvert tegn i matrisen.
        {
            $matrise[$index] = (int) ord($tegn) + $endring--; //Konverterer tegn til nummer, og finner nytt nummer til tegnet.

            //Sikrer at vi får lesbart tegn. 
            if($matrise[$index] < -95)
            {
               $matrise[$index] += 189;
            }
            elseif($matrise[$index] < 32)
            {
               $matrise[$index] += 94;
            }

               $matrise[$index] = chr($matrise[$index]); //Finner ASCII tegn. 
        }
            return implode($matrise); //Matrisen returneres som en string.
    }
    else
    {
        echo "Skriv inn tekst.";
    }
}
?>
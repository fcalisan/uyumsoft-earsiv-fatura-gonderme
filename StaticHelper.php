<?php 

class StaticHelper {
 	public static function priceToText($number)
    {
        $units = ["", "Bir", "İki", "Üç", "Dört", "Beş", "Altı", "Yedi", "Sekiz", "Dokuz"];
        $tens = ["", "On", "Yirmi", "Otuz", "Kırk", "Elli", "Altmış", "Yetmiş", "Seksen", "Doksan"];
        $thousands = ["", "Bin", "Milyon", "Milyar", "Trilyon", "Katrilyon"];

        if ($number == 0) {
            return "Sıfır Türk Lirası";
        }

        $number = number_format($number, 2, '.', '');
        list($integerPart, $fractionalPart) = explode('.', $number);

        $words = "";
        $integerPartLength = strlen($integerPart);
        $groupCount = 0;

        for ($i = 0; $i < $integerPartLength; $i += 3) {
            $digitValues = [0, 0, 0];

            for ($j = 0; $j < 3; $j++) {
                if ($i + $j < $integerPartLength) {
                    $digitValues[$j] = intval($integerPart[$integerPartLength - $i - $j - 1]);
                }
            }

            $groupWords = "";

            if ($digitValues[2] > 0) {
                if ($digitValues[2] == 1) {
                    $groupWords .= "Yüz";
                } else {
                    $groupWords .= $units[$digitValues[2]] . " Yüz";
                }
            }

            if ($digitValues[1] > 0) {
                $groupWords .= " " . $tens[$digitValues[1]];
            }

            if ($digitValues[0] > 0) {
                $groupWords .= " " . $units[$digitValues[0]];
            }

            $groupWords = trim($groupWords);

            if ($groupWords != "") {
                if ($groupCount > 0) {
                    if ($groupWords == "Bir" && $thousands[$groupCount] == "Bin") {
                        $words = $thousands[$groupCount] . " " . $words;
                    } else {
                        $words = $groupWords . " " . $thousands[$groupCount] . " " . $words;
                    }
                } else {
                    $words = $groupWords . " " . $words;
                }
            }

            $groupCount++;
        }

        $words .= " Türk Lirası";

        if ($fractionalPart != "00") {
            $fractionalWords = "";

            $fractionalTens = intval($fractionalPart[0]);
            $fractionalUnits = intval($fractionalPart[1]);

            if ($fractionalTens > 0) {
                $fractionalWords .= $tens[$fractionalTens] . " ";
            }
            if ($fractionalUnits > 0) {
                $fractionalWords .= $units[$fractionalUnits];
            }

            $fractionalWords = trim($fractionalWords);

            if ($fractionalWords != "") {
                $words .= " " . $fractionalWords . " Kuruş";
            }
        }

        return trim($words);
    }
}
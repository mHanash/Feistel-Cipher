<?php

/**
 * Author : Zénas M. MOMONZO
 * Email : zenasmomonzo@gmail.com
 * GitHub : https://github.com/mHanash/
 * @Copyright 2023
 */
require_once dirname(__DIR__) . "/helpers/functions.php";

function decryption(
    array $input,
    array $permuteInput,
    array $permutePart,
    array $keyOne,
    array $keyTwo,
): array {
    $responseData = [];
    $inputPermute = permuteFunction($input, $permuteInput);
    $dividerData = dividerArrayEqualPart($inputPermute);

    $G2 = $dividerData['part1'];
    $D2 = $dividerData['part2'];
    //First Round
    $G1 = permuteFunction(xorFunctionArray($D2, $keyTwo), inversePermuteFunction($permutePart));
    $D1 = xorFunctionArray($G2, orFunctionArray($G1, $keyTwo));
    //Second Round
    $G0 = permuteFunction(xorFunctionArray($D1, $keyOne), inversePermuteFunction($permutePart));
    $D0 = xorFunctionArray($G1, orFunctionArray($G0, $keyOne));

    foreach ($G0 as $value) {
        $responseData[] = $value;
    }
    foreach ($D0 as $value) {
        $responseData[] = $value;
    }
    $responseData = permuteFunction($responseData, inversePermuteFunction($permuteInput));

    return $responseData;
}

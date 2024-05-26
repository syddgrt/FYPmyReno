<?php

use PDF;

$pdf = PDF::create();
$pdf->addHtml('<h1>Hello, World!</h1>');
$pdf->save('example.pdf');

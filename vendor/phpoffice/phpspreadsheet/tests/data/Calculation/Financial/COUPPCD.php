<?php

// Settlement, Maturity, Frequency, Basis, Result

return [
    [
        '25-Jan-2007',
        '15-Nov-2008',
        2,
        1,
        39036,
    ],
    [
        '2011-01-01',
        '2012-10-25',
        4,
        40476,
    ],
    [
        'Invalid Date',
        '15-Nov-2008',
        2,
        1,
        '#VALUE!',
    ],
    [
        '25-Jan-2007',
        'Invalid Date',
        2,
        1,
        '#VALUE!',
    ],
    [
        '25-Jan-2007',
        '15-Nov-2008',
        3,
        1,
        '#NUM!',
    ],
];

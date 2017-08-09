<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/8/2017
 * Time: 2:40 AM
 */

namespace AnimalAllies;


class Validator {

    public $regexFor = [
        'ascii' => [
            'html5' => '([\w\d\s.,?!:;\x27\x22\[\](){}@#$%&`~\-\^=+*<>\\/|]{1,999})',
            'php'   => '
\A                 # beginning of string
(                  # start capture group
  [ -~\s]{1,999}   # ascii character range from space to ~, and \s, 1-999 times
)                  # end capture group
\z                 # end of the sting
'
        ],
        'email' => [
            'html5' => '[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,24}',
            'php'   => '
\A                    # beginning of string
(                     # start capture group
  [\s]*               # space character zero more times
  [A-Za-z0-9._%+\-]+  # letters, digits, and . _ % + - one or more times
  @                   # @ sign one time
  [A-Za-z0-9.\-]+     # letters, digits, period, dash one or more times
  \.                  # period one time
  [A-Za-z]{2,24}      # letters 2 to 24 times
  \s{0,10}
)                     # end capture group
\z'
        ],
        'phone' => [
            'html5' => '\(?([0-9]{3})\)?[\-. ]?([0-9]{3})[\-. ]?([0-9]{4})',
            'php'   => '
\A                # beginning of string
(                 # start capture group
  \(?             # opening parenthesis 0 or 1 time
  (?:             # non capturing group
    [0-9]{3}      # number 0-9 three times
  )               # end non-capture group     
  \)?             # closing parenthesis 0 or 1 time
  [\-. ]?         # a dash, period, or single space zero or 1 time
  (?:             # start non capture group
    [0-9]{3}      # number 0-9 three times
  )               # end non-capture group
  [\-. ]?         # a dash, period, or single space zero or 1 time
  (?:             # start non capture group
    [0-9]{4}      # 0-9 four times
  )               # end non capture group
)                 # end capture group
\z                # end of string 
',
        ],
        'yesOrNo' => [
            'html5' => '',
            'php'   => '
\A                # beginning of string
(                 # start capture group
  (?:yes|no)      # no capture group of either yes or no
)                 # end capture group
\z',
        ],
        'text' => [
            'html5' => '[\w\s\!#]{0,250}',
            'php'   => '\A([\w\s]{0,500})\z'
        ]
    ];

    public function validate($type, $value) {
        $regex = $this->regexFor[$type]['php'];
        $result = "";
        if ( ! preg_match("!$regex!xms", $value, $result)) {
            return false;
        }
        return $result[1];
    }
}

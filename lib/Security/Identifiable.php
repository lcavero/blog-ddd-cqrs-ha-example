<?php

namespace Lib\Security;

use Lib\ValueObject\Id;

interface Identifiable
{
    public function id(): Id;
}

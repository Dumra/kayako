<?php

require_once 'bootstrap/app.php';

kyConfig::set(new kyConfig(API_URL, API_KEY, SECRET_KEY));
kyConfig::get()->setDebugEnabled(true);
var_dump(kyUser::getAll());


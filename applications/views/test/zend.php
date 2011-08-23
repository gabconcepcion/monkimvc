<?php

echo '<br/><b>*Make sure that the Zend library exists on dir ../library or /libary*</b>';

echo '<br/>Zend_Json::encode: '.$json;
echo '<br/>Zend_Json::decode: <pre>'.var_export(Zend_Json::decode($json), true).'</pre>';

echo '<br/>Zend_Locale:'.var_export($myLocale,true);
echo '<br/>Start:'.$start_time.'ms';
echo '<br/>End:'.time().'ms';
echo '<br/>Process:'.( (time()-$start_time)).'s';

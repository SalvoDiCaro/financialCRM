<?php

namespace App\Classes;

use App\Contracts\VcardHandler;
use App\Models\Contact;

class VcardHandler3 implements VcardHandler
{
	public function import($file,$rubric)
	{
		$vcardarray = explode("END:VCARD\r\n", $file);
	        foreach ($vcardarray as $vcard)
		{
        	        if(empty(trim($vcard))) continue;
                	$contact = new Contact();
                	$contact->payload = $vcard."END:VCARD\r\n";
                	$rubric->contacts()->save($contact);
        	}
		return $contact;
	}

	public function export($rubric)
	{
		$contacts = $rubric->contacts()->get();
		$exported = "";
		foreach ($contacts as $contact){
			$exported.=$contact->payload;
		}
		return response()->streamDownload(function () use ($exported) {
			echo $exported;
		}, $rubric->name.".vcf");

	}	
}

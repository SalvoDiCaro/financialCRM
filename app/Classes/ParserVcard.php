<?php

namespace App\Classes;

use App\Models\Contact;
use App\Contracts\ParserHandler;
use JeroenDesloovere\VCard\VCard;
use JeroenDesloovere\VCard\VCardParser;
use App\Classes\CropperImageContact;
use Illuminate\Support\Facades\Storage;

class ParserVcard implements ParserHandler
{
	public function newVCardRequest($request)
	{
		$vcard= new VCard();

		$vcard->addName($request->surname, $request->name);
		$vcard->addCompany($request->company);
		$vcard->addJobTitle($request->JobTitle);
		if(isset($request->image))
		{
			$crop=new CropperImageContact();
			$path=$crop->Crop($request);

			$url=Storage::disk('public')->url($path);
			$vcard->addPhoto($url);
		}
		if(isset($request->address))
		{
		foreach($request->address as $address){
			$vcard->addAddress($address['address_name'] ?? "", $address['address_extended'] ?? "", $address['address_street'] ?? "", $address['address_city'] ?? "", $address['address_region'] ?? "", $address['address_zip'] ?? "", $address['address_country'] ?? "");
		}
		}
		if(isset($request->url)){
			foreach($request->url as $url)
			{
				if($url){
					$vcard->addUrl($url);
				}
			}
		}
		if(isset($request->email)){
			foreach($request->email as $email)
			{
				if($email){
					$vcard->addEmail($email);
				}
			}
		}
		if(isset($request->phone)){
			foreach($request->phone as $phone)
			{
				if($phone){
					$vcard->addPhoneNumber($phone);
				}
			}
		}

		return $vcard;
 	}

	public function ParserPayload($payload)
	{
		$contact= new Contact();
		$parser = new VCardParser($payload);

		$contact->title= $parser->getCardAtIndex(0)->title;
		$contact->name = $parser->getCardAtIndex(0)->firstname;
		$contact->surname = $parser->getCardAtIndex(0)->lastname;
		$phones=[];
		if(isset($parser->getCardAtIndex(0)->phone)){
			foreach($parser->getCardAtIndex(0)->phone as $phone){
				foreach($phone as $ph){
					$phones[]= $ph;
				}
			}
		}
		$contact->phone=$phones;
		$emails=[];
		if(isset($parser->getCardAtIndex(0)->email)){
			foreach($parser->getCardAtIndex(0)->email as $mail){
				foreach($mail as $email){
					$emails[]=$email;
				}
			}
		}
		$contact->email = $emails;
		$address=[];
		if(isset($parser->getCardAtIndex(0)->address)){
			foreach($parser->getCardAtIndex(0)->address as $add){
				foreach($add as $addr){
					$temp['name']=$addr->name;
					$temp['extended']=$addr->extended;
					$temp['street']=$addr->street;
					$temp['city']=$addr->city;
					$temp['region']=$addr->region;
					$temp['zip']=$addr->zip;
					$temp['country']=$addr->country;
					$address[] = $temp;
				}
			}
		}
		$contact->address = $address;
		if(isset($parser->getCardAtIndex(0)->organization)){
			$contact->company = $parser->getCardAtIndex(0)->organization;
		}
		if(isset($parser->getCardAtIndex(0)->title)){
			$contact->jobtitle = $parser->getCardAtIndex(0)->title;
		}
		$url=[];
		if(isset($parser->getCardAtIndex(0)->url)){
			foreach($parser->getCardAtIndex(0)->url as $site){
				foreach($site as $links){
				$url[] = $links;
				}
			}
		}
		$contact->url= $url;

		if(isset($parser->getCardAtIndex(0)->rawPhoto))
		{
			$contact->photo=$parser->getCardAtIndex(0)->rawPhoto;
		}

		return $contact;
	}
}


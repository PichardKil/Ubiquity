<?php
return array(
	"siteUrl"=>"http://127.0.0.1:8090/",
	"database"=>[
			"type"=>"mysql",
			"dbName"=>"store",
			"serverName"=>"127.0.0.1",
			"port"=>8889,
			"user"=>"root",
			"password"=>"root",
			"options"=>array(),
			"cache"=>false,
			"wrapper"=>"Ubiquity\\db\\providers\\pdo\\PDOWrapper"
			],
	"sessionName"=>"s60210af0a5644",
	"namespaces"=>array(),
	"templateEngine"=>"Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions"=>[
			"cache"=>false
			],
	"test"=>false,
	"debug"=>true,
	"logger"=>function (){
		return new \Ubiquity\log\libraries\UMonolog(array (
  'host' => '127.0.0.1',
  'port' => 8090,
  'sessionName' => 's60210af0a5644',
)['sessionName'], \Monolog\Logger::INFO);
	},
	"di"=>[
			"@exec"=>array("jquery"=>function ($controller){
						return \Ubiquity\core\Framework::diSemantic($controller);
					})
			],
	"cache"=>[
			"directory"=>"cache/",
			"system"=>"Ubiquity\\cache\\system\\ArrayCache",
			"params"=>array()
			],
	"mvcNS"=>[
			"models"=>"models",
			"controllers"=>"controllers",
			"rest"=>""
			],
	"isRest"=>function (){
			return \Ubiquity\utils\http\URequest::getUrlParts()[0]==="rest";
		}
	);
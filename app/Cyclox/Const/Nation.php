<?php

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * 国オブジェクト
 */
class Nation
{
	private static $nations;
	private static $JPN;
	private static $unknownNation;
	
	public static function nations()
	{
		return self::$nations;
	}
	
	/**
	 * 日本 Nation をかえす
	 * @return Nation 日本 Nation インスタンス
	 */
	public static function JPN()
	{
		return self::$JPN;
	}
	
	public static function unknownNation()
	{
		return self::$unknownNation;
	}
	
	public static function init()
	{
		self::$JPN = new Nation('JPN', '日本', 'Japan', '東アジア');
		self::$unknownNation = new Nation('XXX', '不明な国', 'UnknownCountry', '???');
		
		self::$nations = array(
			new Nation('ISL', 'アイスランド', 'Iceland', '北ヨーロッパ'),                                       
			new Nation('IRL', 'アイルランド', 'Ireland', '西ヨーロッパ'),                                       
			new Nation('AZE', 'アゼルバイジャン', 'Azerbaijan', '東ヨーロッパ'),                                
			new Nation('AFG', 'アフガニスタン', 'Afghanistan', '中東'),                                         
			new Nation('USA', 'アメリカ合衆国', 'United States', '北アメリカ'),                                 
			new Nation('VIR', 'アメリカ領ヴァージン諸島', 'Virgin Islands, U.S.', '中央アメリカ'),              
			new Nation('ASM', 'アメリカ領サモア', 'American Samoa', 'オセアニア'),                              
			new Nation('ARE', 'アラブ首長国連邦', 'United Arab Emirates', '中東'),                              
			new Nation('DZA', 'アルジェリア', 'Algeria', '北アフリカ'),                                                                                                 
			new Nation('ARG', 'アルゼンチン', 'Argentina', '南アメリカ'),                                       
			new Nation('ABW', 'アルバ', 'Aruba', '中央アメリカ'),                                               
			new Nation('ALB', 'アルバニア', 'Albania', '東ヨーロッパ'),                                         
			new Nation('ARM', 'アルメニア', 'Armenia', '東ヨーロッパ'),                                         
			new Nation('AIA', 'アンギラ', 'Anguilla', '中央アメリカ'),                                          
			new Nation('AGO', 'アンゴラ', 'Angola', '南アフリカ'),                                              
			new Nation('ATG', 'アンティグア・バーブーダ', 'Antigua and Barbuda', '中央アメリカ'),               
			new Nation('AND', 'アンドラ', 'Andorra', '西ヨーロッパ'),                                           
			new Nation('YEM', 'イエメン', 'Yemen', '中東'),                                                     
			new Nation('GBR', 'イギリス', 'United Kingdom', '西ヨーロッパ'),                                    
			new Nation('IOT', 'イギリス領インド洋地域', 'British Indian Ocean Territory', 'インド洋地域'),   
			new Nation('VGB', 'イギリス領ヴァージン諸島', 'Virgin Islands, British', '中央アメリカ'),           
			new Nation('ISR', 'イスラエル', 'Israel', '中東'),                                                  
			new Nation('ITA', 'イタリア', 'Italy', '西ヨーロッパ'),                                             
			new Nation('IRQ', 'イラク', 'Iraq', '中東'),                                                        
			new Nation('IRN', 'イラン・イスラム共和国', 'Iran, Islamic Republic of', '中東'),                   
			new Nation('IND', 'インド', 'India', '南アジア'),                                                   
			new Nation('IDN', 'インドネシア', 'Indonesia', '東南アジア'),                                       
			new Nation('WLF', 'ウォリス・フツナ', 'Wallis and Futuna', 'オセアニア'),                           
			new Nation('UGA', 'ウガンダ', 'Uganda', '中央アフリカ'),                                            
			new Nation('UKR', 'ウクライナ', 'Ukraine', '東ヨーロッパ'),                                         
			new Nation('UZB', 'ウズベキスタン', 'Uzbekistan', '中央アジア'),                                    
			new Nation('URY', 'ウルグアイ', 'Uruguay', '南アメリカ'),                                           
			new Nation('ECU', 'エクアドル', 'Ecuador', '南アメリカ'),                                           
			new Nation('EGY', 'エジプト', 'Egypt', '北アフリカ'),                                               
			new Nation('EST', 'エストニア', 'Estonia', '東ヨーロッパ'),                                         
			new Nation('ETH', 'エチオピア', 'Ethiopia', '東アフリカ'),                                          
			new Nation('ERI', 'エリトリア', 'Eritrea', '東アフリカ'),                                           
			new Nation('SLV', 'エルサルバドル', 'El Salvador', '中央アメリカ'),                                 
			new Nation('AUS', 'オーストラリア', 'Australia', 'オセアニア'),                                     
			new Nation('AUT', 'オーストリア', 'Austria', '東ヨーロッパ'),                                          
			new Nation('ALA', 'オーランド諸島', 'Åland Islands', '北ヨーロッパ'),                               
			new Nation('OMN', 'オマーン', 'Oman', '中東'),                                                      
			new Nation('NLD', 'オランダ', 'Netherlands', '西ヨーロッパ'),                                       
			new Nation('GHA', 'ガーナ', 'Ghana', '西アフリカ'),                                                 
			new Nation('CPV', 'カーボベルデ', 'Cape Verde', '西アフリカ'),                                      
			new Nation('GGY', 'ガーンジー', 'Guernsey', '西ヨーロッパ'),                                        
			new Nation('GUY', 'ガイアナ', 'Guyana', '南アメリカ'),                                              
			new Nation('KAZ', 'カザフスタン', 'Kazakhstan', '中央アジア'),                                      
			new Nation('QAT', 'カタール', 'Qatar', '中東'),                                                     
			new Nation('UMI', '合衆国領有小離島', 'United States Minor Outlying Islands', 'オセアニア'),        
			new Nation('CAN', 'カナダ', 'Canada', '北アメリカ'),                                                
			new Nation('GAB', 'ガボン', 'Gabon', '中央アフリカ'),                                               
			new Nation('CMR', 'カメルーン', 'Cameroon', '中央アフリカ'),                                        
			new Nation('GMB', 'ガンビア', 'Gambia', '西アフリカ'),                                              
			new Nation('KHM', 'カンボジア', 'Cambodia', '東南アジア'),                                          
			new Nation('MNP', '北マリアナ諸島', 'Northern Mariana Islands', 'オセアニア'),                      
			new Nation('GIN', 'ギニア', 'Guinea', '西アフリカ'),                                                
			new Nation('GNB', 'ギニアビサウ', 'Guinea-Bissau', '西アフリカ'),                                   
			new Nation('CYP', 'キプロス', 'Cyprus', '地中海地域'),                                              
			new Nation('CUB', 'キューバ', 'Cuba', '中央アメリカ'),                                              
			new Nation('CUW', 'キュラソー', 'Curaçao', '中央アメリカ'),                                         
			new Nation('GRC', 'ギリシャ', 'Greece', '西ヨーロッパ'),                                            
			new Nation('KIR', 'キリバス', 'Kiribati', 'オセアニア'),                                            
			new Nation('KGZ', 'キルギス', 'Kyrgyzstan', '中央アジア'),                                          
			new Nation('GTM', 'グアテマラ', 'Guatemala', '中央アメリカ'),                                       
			new Nation('GLP', 'グアドループ', 'Guadeloupe', '中央アメリカ'),                                    
			new Nation('GUM', 'グアム', 'Guam', 'オセアニア'),                                                  
			new Nation('KWT', 'クウェート', 'Kuwait', '中東'),                                                  
			new Nation('COK', 'クック諸島', 'Cook Islands', 'オセアニア'),                                                                                              
			new Nation('GRL', 'グリーンランド', 'Greenland', '北ヨーロッパ'),                                   
			new Nation('CXR', 'クリスマス島', 'Christmas Island', 'オセアニア'),                                
			new Nation('GEO', 'グルジア', 'Georgia', '東ヨーロッパ'),                                           
			new Nation('GRD', 'グレナダ', 'Grenada', '中央アメリカ'),                                           
			new Nation('HRV', 'クロアチア', 'Croatia', '東ヨーロッパ'),                                         
			new Nation('CYM', 'ケイマン諸島', 'Cayman Islands', '中央アメリカ'),                                
			new Nation('KEN', 'ケニア', 'Kenya', '東アフリカ'),                                                 
			new Nation('CIV', 'コートジボワール', "Côte d'Ivoire", '西アフリカ'),                               
			new Nation('CCK', 'ココス（キーリング）諸島', 'Cocos (Keeling) Islands', 'インド洋地域'), 
			new Nation('CRI', 'コスタリカ', 'Costa Rica', '中央アメリカ'),                                      
			new Nation('COM', 'コモロ', 'Comoros', 'インド洋地域'),                                             
			new Nation('COL', 'コロンビア', 'Colombia', '南アメリカ'),                                          
			new Nation('COG', 'コンゴ共和国', 'Congo', '中央アフリカ'),                                         
			new Nation('COD', 'コンゴ民主共和国', 'Congo, the Democratic Republic of the', '中央アフリカ'),     
			new Nation('SAU', 'サウジアラビア', 'Saudi Arabia', '中東'),                                        
			new Nation('SGS', 'サウスジョージア・サウスサンドウィッチ諸島', 'South Georgia and the South Sandwich Islands', '南アメリカ'),
			new Nation('WSM', 'サモア', 'Samoa', 'オセアニア'),                                                 
			new Nation('STP', 'サントメ・プリンシペ', 'Sao Tome and Principe', '中央アフリカ'),                 
			new Nation('BLM', 'サン・バルテルミー', 'Saint Barthélemy', '中央アメリカ'),                        
			new Nation('ZMB', 'ザンビア', 'Zambia', '南アフリカ'),                                              
			new Nation('SPM', 'サンピエール島・ミクロン島', 'Saint Pierre and Miquelon', '北アメリカ'),         
			new Nation('SMR', 'サンマリノ', 'San Marino', '西ヨーロッパ'),                                      
			new Nation('MAF', 'サン・マルタン（フランス領）', 'Saint Martin (French part)', '中央アメリカ'),    
			new Nation('SLE', 'シエラレオネ', 'Sierra Leone', '西アフリカ'),                                    
			new Nation('DJI', 'ジブチ', 'Djibouti', '東アフリカ'),                                              
			new Nation('GIB', 'ジブラルタル', 'Gibraltar', '西ヨーロッパ'),                                     
			new Nation('JEY', 'ジャージー', 'Jersey', '西ヨーロッパ'),                                          
			new Nation('JAM', 'ジャマイカ', 'Jamaica', '中央アメリカ'),                                         
			new Nation('SYR', 'シリア・アラブ共和国', 'Syrian Arab Republic', '中東'),                          
			new Nation('SGP', 'シンガポール', 'Singapore', '東南アジア'),                                       
			new Nation('SXM', 'シント・マールテン（オランダ領）', 'Sint Maarten (Dutch part)', '中央アメリカ'), 
			new Nation('ZWE', 'ジンバブエ', 'Zimbabwe', '南アフリカ'),                                          
			new Nation('CHE', 'スイス', 'Switzerland', '西ヨーロッパ'),                                         
			new Nation('SWE', 'スウェーデン', 'Sweden', '北ヨーロッパ'),                                        
			new Nation('SDN', 'スーダン', 'Sudan', '東アフリカ'),                                               
			new Nation('SJM', 'スヴァールバル諸島およびヤンマイエン島', 'Svalbard and Jan Mayen', '北ヨーロッパ'),
			new Nation('ESP', 'スペイン', 'Spain', '西ヨーロッパ'),                                             
			new Nation('SUR', 'スリナム', 'Suriname', '南アメリカ'),                                            
			new Nation('LKA', 'スリランカ', 'Sri Lanka', '南アジア'),                                           
			new Nation('SVK', 'スロバキア', 'Slovakia', '東ヨーロッパ'),                                        
			new Nation('SVN', 'スロベニア', 'Slovenia', '東ヨーロッパ'),                                        
			new Nation('SWZ', 'スワジランド', 'Swaziland', '南アフリカ'),                                       
			new Nation('SYC', 'セーシェル', 'Seychelles', 'インド洋地域'),                                      
			new Nation('GNQ', '赤道ギニア', 'Equatorial Guinea', '中央アフリカ'),                               
			new Nation('SEN', 'セネガル', 'Senegal', '西アフリカ'),                                             
			new Nation('SRB', 'セルビア', 'Serbia', '東ヨーロッパ'),                                            
			new Nation('KNA', 'セントクリストファー・ネイビス', 'Saint Kitts and Nevis', '中央アメリカ'),       
			new Nation('VCT', 'セントビンセントおよびグレナディーン諸島', 'Saint Vincent and the Grenadines', '中央アメリカ'),
			new Nation('SHN', 'セントヘレナ・アセンションおよびトリスタンダクーニャ', 'Saint Helena, Ascension and Tristan da Cunha', '西アフリカ'),
			new Nation('LCA', 'セントルシア', 'Saint Lucia', '中央アメリカ'),                                   
			new Nation('SOM', 'ソマリア', 'Somalia', '東アフリカ'),                                             
			new Nation('SLB', 'ソロモン諸島', 'Solomon Islands', 'オセアニア'),                                 
			new Nation('TCA', 'タークス・カイコス諸島', 'Turks and Caicos Islands', '中央アメリカ'),            
			new Nation('THA', 'タイ', 'Thailand', '東南アジア'),                                                
			new Nation('KOR', '大韓民国', 'Korea, Republic of', '東アジア'),                                    
			new Nation('TWN', '台湾（台湾省/中華民国）', 'Taiwan, Province of China', '東アジア'),              
			new Nation('TJK', 'タジキスタン', 'Tajikistan', '中央アジア'),                                      
			new Nation('TZA', 'タンザニア', 'Tanzania, United Republic of', '東アフリカ'),                      
			new Nation('CZE', 'チェコ', 'Czech Republic', '東ヨーロッパ'),                                      
			new Nation('TCD', 'チャド', 'Chad', '中央アフリカ'),                                                                                                        
			new Nation('CAF', '中央アフリカ共和国', 'Central African Republic', '中央アフリカ'),                
			new Nation('CHN', '中華人民共和国', 'China', '東アジア'),                                           
			new Nation('TUN', 'チュニジア', 'Tunisia', '北アフリカ'),                                           
			new Nation('PRK', '朝鮮民主主義人民共和国', "Korea, Democratic People's Republic of", '東アジア'),  
			new Nation('CHL', 'チリ', 'Chile', '南アメリカ'),                                                   
			new Nation('TUV', 'ツバル', 'Tuvalu', 'オセアニア'),                                                
			new Nation('DNK', 'デンマーク', 'Denmark', '北ヨーロッパ'),                                         
			new Nation('DEU', 'ドイツ', 'Germany', '西ヨーロッパ'),     
			new Nation('TGO', 'トーゴ', 'Togo', '西アフリカ'),                                                  
			new Nation('TKL', 'トケラウ', 'Tokelau', 'オセアニア'),                                             
			new Nation('DOM', 'ドミニカ共和国', 'Dominican Republic', '中央アメリカ'),                          
			new Nation('DMA', 'ドミニカ国', 'Dominica', '中央アメリカ'),                                        
			new Nation('TTO', 'トリニダード・トバゴ', 'Trinidad and Tobago', '中央アメリカ'),                   
			new Nation('TKM', 'トルクメニスタン', 'Turkmenistan', '中央アジア'),                                
			new Nation('TUR', 'トルコ', 'Turkey', '中東'),                                                      
			new Nation('TON', 'トンガ', 'Tonga', 'オセアニア'),                                                 
			new Nation('NGA', 'ナイジェリア', 'Nigeria', '中央アフリカ'),                                       
			new Nation('NRU', 'ナウル', 'Nauru', 'オセアニア'),                                                 
			new Nation('NAM', 'ナミビア', 'Namibia', '南アフリカ'),                                             
			new Nation('ATA', '南極', 'Antarctica', '南極'),                                                    
			new Nation('NIU', 'ニウエ', 'Niue', 'オセアニア'),                                                  
			new Nation('NIC', 'ニカラグア', 'Nicaragua', '中央アメリカ'),                                       
			new Nation('NER', 'ニジェール', 'Niger', '中央アフリカ'),                                           
			self::$JPN,
			new Nation('ESH', '西サハラ', 'Western Sahara', '西アフリカ'),                                      
			new Nation('NCL', 'ニューカレドニア', 'New Caledonia', 'オセアニア'),                               
			new Nation('NZL', 'ニュージーランド', 'New Zealand', 'オセアニア'),                                 
			new Nation('NPL', 'ネパール', 'Nepal', '南アジア'),                                                 
			new Nation('NFK', 'ノーフォーク島', 'Norfolk Island', 'オセアニア'),                                
			new Nation('NOR', 'ノルウェー', 'Norway', '北ヨーロッパ'),                                          
			new Nation('HMD', 'ハード島とマクドナルド諸島', 'Heard Island and McDonald Islands', 'インド洋地域'),
			new Nation('BHR', 'バーレーン', 'Bahrain', '中東'),                                                 
			new Nation('HTI', 'ハイチ', 'Haiti', '中央アメリカ'),                                               
			new Nation('PAK', 'パキスタン', 'Pakistan', '南アジア'),                                            
			new Nation('VAT', 'バチカン市国', 'Holy See (Vatican City State)', '西ヨーロッパ'),                 
			new Nation('PAN', 'パナマ', 'Panama', '中央アメリカ'),                                              
			new Nation('VUT', 'バヌアツ', 'Vanuatu', 'オセアニア'),                                             
			new Nation('BHS', 'バハマ', 'Bahamas', '中央アメリカ'),                                             
			new Nation('PNG', 'パプアニューギニア', 'Papua New Guinea', 'オセアニア'),                          
			new Nation('BMU', 'バミューダ', 'Bermuda', '中央アメリカ'),                                         
			new Nation('PLW', 'パラオ', 'Palau', 'オセアニア'),                                                 
			new Nation('PRY', 'パラグアイ', 'Paraguay', '南アメリカ'),                                          
			new Nation('BRB', 'バルバドス', 'Barbados', '中央アメリカ'),                                        
			new Nation('PSE', 'パレスチナ', 'Palestinian Territory, Occupied', '中東'),                         
			new Nation('HUN', 'ハンガリー', 'Hungary', '東ヨーロッパ'),                                         
			new Nation('BGD', 'バングラデシュ', 'Bangladesh', '南アジア'),                                      
			new Nation('TLS', '東ティモール', 'Timor-Leste', '東南アジア'),                                     
			new Nation('PCN', 'ピトケアン', 'Pitcairn', 'オセアニア'),                                          
			new Nation('FJI', 'フィジー', 'Fiji', 'オセアニア'),                                                
			new Nation('PHL', 'フィリピン', 'Philippines', '東南アジア'),                                       
			new Nation('FIN', 'フィンランド', 'Finland', '北ヨーロッパ'),                                       
			new Nation('BTN', 'ブータン', 'Bhutan', '南アジア'),                                                
			new Nation('BVT', 'ブーベ島', 'Bouvet Island', '南極'),                                             
			new Nation('PRI', 'プエルトリコ', 'Puerto Rico', '中央アメリカ'),                                   
			new Nation('FRO', 'フェロー諸島', 'Faroe Islands', '北ヨーロッパ'),                                 
			new Nation('FLK', 'フォークランド（マルビナス）諸島', 'Falkland Islands (Malvinas)', '南アメリカ'), 
			new Nation('BRA', 'ブラジル', 'Brazil', '南アメリカ'),                                              
			new Nation('FRA', 'フランス', 'France', '西ヨーロッパ'),                                            
			new Nation('GUF', 'フランス領ギアナ', 'French Guiana', '南アメリカ'),                               
			new Nation('PYF', 'フランス領ポリネシア', 'French Polynesia', 'オセアニア'),                                                                                
			new Nation('ATF', 'フランス領南方・南極地域', 'French Southern Territories', 'インド洋地域'),       
			new Nation('BGR', 'ブルガリア', 'Bulgaria', '東ヨーロッパ'),                                        
			new Nation('BFA', 'ブルキナファソ', 'Burkina Faso', '西アフリカ'),                                  
			new Nation('BRN', 'ブルネイ・ダルサラーム', 'Brunei Darussalam', '東南アジア'),                     
			new Nation('BDI', 'ブルンジ', 'Burundi', '中央アフリカ'),
			new Nation('VNM', 'ベトナム', 'Viet Nam', '東南アジア'),                                            
			new Nation('BEN', 'ベナン', 'Benin', '西アフリカ'),                                                 
			new Nation('VEN', 'ベネズエラ・ボリバル共和国', 'Venezuela, Bolivarian Republic of', '南アメリカ'), 
			new Nation('BLR', 'ベラルーシ', 'Belarus', '東ヨーロッパ'),                                         
			new Nation('BLZ', 'ベリーズ', 'Belize', '中央アメリカ'),                                            
			new Nation('PER', 'ペルー', 'Peru', '南アメリカ'),                                                  
			new Nation('BEL', 'ベルギー', 'Belgium', '西ヨーロッパ'),                                           
			new Nation('POL', 'ポーランド', 'Poland', '東ヨーロッパ'),                                          
			new Nation('BIH', 'ボスニア・ヘルツェゴビナ', 'Bosnia and Herzegovina', '東ヨーロッパ'),            
			new Nation('BWA', 'ボツワナ', 'Botswana', '南アフリカ'),                                            
			new Nation('BES', 'ボネール、シント・ユースタティウスおよびサバ', 'Bonaire, Saint Eustatius and Saba', '中央アメリカ'),
			new Nation('BOL', 'ボリビア多民族国', 'Bolivia, Plurinational State of', '南アメリカ'),             
			new Nation('PRT', 'ポルトガル', 'Portugal', '西ヨーロッパ'),                                        
			new Nation('HKG', '香港', 'Hong Kong', '東アジア'),                                                 
			new Nation('HND', 'ホンジュラス', 'Honduras', '中央アメリカ'),                                      
			new Nation('MHL', 'マーシャル諸島', 'Marshall Islands', 'オセアニア'),                              
			new Nation('MAC', 'マカオ', 'Macao', '東アジア'),                                                   
			new Nation('MKD', 'マケドニア旧ユーゴスラビア共和国', 'Macedonia, the former Yugoslav Republic of', '東ヨーロッパ'),
			new Nation('MDG', 'マダガスカル', 'Madagascar', 'インド洋地域'),                                    
			new Nation('MYT', 'マヨット', 'Mayotte', 'インド洋地域'),                                           
			new Nation('MWI', 'マラウイ', 'Malawi', '南アフリカ'),                                              
			new Nation('MLI', 'マリ', 'Mali', '西アフリカ'),                                                    
			new Nation('MLT', 'マルタ', 'Malta', '地中海地域'),                                                 
			new Nation('MTQ', 'マルティニーク', 'Martinique', '中央アメリカ'),                                  
			new Nation('MYS', 'マレーシア', 'Malaysia', '東南アジア'),                                          
			new Nation('IMN', 'マン島', 'Isle of Man', '西ヨーロッパ'),                                         
			new Nation('FSM', 'ミクロネシア連邦', 'Micronesia, Federated States of', 'オセアニア'),             
			new Nation('ZAF', '南アフリカ', 'South Africa', '南アフリカ'),                                      
			new Nation('SSD', '南スーダン', 'South Sudan', '東アフリカ'),                                       
			new Nation('MMR', 'ミャンマー', 'Myanmar', '東南アジア'),                                           
			new Nation('MEX', 'メキシコ', 'Mexico', '中央アメリカ'),                                            
			new Nation('MUS', 'モーリシャス', 'Mauritius', '南アフリカ'),                                       
			new Nation('MRT', 'モーリタニア', 'Mauritania', '西アフリカ'),                                      
			new Nation('MOZ', 'モザンビーク', 'Mozambique', '南アフリカ'),                                      
			new Nation('MCO', 'モナコ', 'Monaco', '西ヨーロッパ'),                                              
			new Nation('MDV', 'モルディブ', 'Maldives', 'インド洋地域'),                                        
			new Nation('MDA', 'モルドバ共和国', 'Moldova, Republic of', '東ヨーロッパ'),                        
			new Nation('MAR', 'モロッコ', 'Morocco', '北アフリカ'),                                             
			new Nation('MNG', 'モンゴル', 'Mongolia', '東アジア'),                                              
			new Nation('MNE', 'モンテネグロ', 'Montenegro', '東ヨーロッパ'),                                    
			new Nation('MSR', 'モントセラト', 'Montserrat', '中央アメリカ'),                                    
			new Nation('JOR', 'ヨルダン', 'Jordan', '中東'),                                                    
			new Nation('LAO', 'ラオス人民民主共和国', "Lao People's Democratic Republic", '東南アジア'),        
			new Nation('LVA', 'ラトビア', 'Latvia', '東ヨーロッパ'),                                            
			new Nation('LTU', 'リトアニア', 'Lithuania', '東ヨーロッパ'),                                       
			new Nation('LBY', 'リビア', 'Libya', '北アフリカ'),                                                 
			new Nation('LIE', 'リヒテンシュタイン', 'Liechtenstein', '西ヨーロッパ'),                           
			new Nation('LBR', 'リベリア', 'Liberia', '西アフリカ'),                                             
			new Nation('ROU', 'ルーマニア', 'Romania', '東ヨーロッパ'),                                         
			new Nation('LUX', 'ルクセンブルク', 'Luxembourg', '西ヨーロッパ'),                                  
			new Nation('RWA', 'ルワンダ', 'Rwanda', '中央アフリカ'),                                            
			new Nation('LSO', 'レソト', 'Lesotho', '南アフリカ'),                                               
			new Nation('LBN', 'レバノン', 'Lebanon', '中東'),                                                   
			new Nation('REU', 'レユニオン', 'Réunion', 'インド洋地域'),                                         
			new Nation('RUS', 'ロシア連邦', 'Russian Federation', 'ロシア')
		);
	}
	
	private $code; // 3文字
	private $nameJp;
	private $nameEn;
	private $location;
	
	private function __construct($c, $j, $e, $l)
	{
		$this->code = $c;
		$this->nameJp = $j;
		$this->nameEn = $e;
		$this->location = $l;
	}
	
	/** return string  */
	public function code() { return $this->code; }
	/** return string  */
	public function nameJp() { return $this->nameJp; }
	/** return string  */
	public function nameEn() { return $this->nameEn; }
	/** return string  */
	public function location() { return $this->location; }
}
Nation::init();

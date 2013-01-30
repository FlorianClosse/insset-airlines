<?php
/*

----------------------------------------------
|   CE FICHIER EST LIVRE PAR LE FRAMEWORK.   |
|        IL NE DOIT PAS ETRE MODIFIE         |
|     POUR LES BESOINS DE L'APPLICATION.     |
----------------------------------------------

*/

/*
 $Id: Mnemo.php,v 1.2 2008/05/28 14:46:43 sekaijin Exp $
*/


/**
 * Générateur de mots de passe mnémotechniques.
* Basé sur un concept phonétique, il utilise une base lexicale de
* bi et trigrammes français. Cette liste syllabique est une compilation
* d'études universitaires diverses, adaptée pour répondre au mieux au besoin.
* Entre autre, toutes les syllabes contenant un 'o' ou un 'i' ont été retirées
* pour ne pas engendrer de confusion avec le 'un' et le 'zéro' dans certaines
* polices.
* <br />
* La méthode de génération consiste à assembler une ou plusieurs syllabes
* et chiffres, tout cela dans un "apparent désordre". Il n'y a jamais de
* doubles lettres car le début d'une syllabe doit être antonyme à la fin de
* la précédente (sauf casse différente). Les syllabes sont aléatoirement en
* minuscules ou majuscules. De 0 à 2 chiffres sont insérés entre chaque
* syllabe.
*
* @remark
* La présente version n'utilise pas de caractères spéciaux.
*
* @todo
* Prévoir les méthodes pour insérer au choix des caractères spéciaux, les spécifier éventuellment.
*
* @package   Fast
* @copyright  ftgroup
* @author Patrick Dubois
* @subpackage Fast_Pass_Mnemo
*/
class Fast_Pass_Mnemo {

	/**
	 Fournit la version de cette classe.
	 */
	static public function getVersion() {
		return "1.12.0";
	} // end function getVersion

	/**
	 Retourne un mot de passe
	 @param length (int) nombre de caractères des mots de passe (8)
	 @return (string) : mot de passe
	 */
	static public function getOne($length=8) 
	{
		if ($length < 1) return false;
		$lex = Fast_Pass_Mnemo::getLex();
		if ($length < 1) $length = 1;
		$voyels = explode(",", "a,e,u,y,A,E,U,Y");
		$conson = explode(",", "b,c,d,f,g,h,j,k,m,n,p,q,r,s,t,v,w,x,z,B,C,D,F,G,H,J,K,M,N,P,Q,R,S,T,V,W,X,Z");
		$pass   = "";
		while (strlen($pass) < $length) {
			// syllabe suivante
			$syl = trim($lex[rand(0, count($lex)-1)]);
			if (!empty($pass)) {
				// une syllabe doit commencer par une lettre antonyme à la dernière du mot en cours.
				if (in_array(substr($pass, -1, 1), $voyels) and in_array(substr($syl, 0, 1), $voyels)) continue;
				if (in_array(substr($pass, -1, 1), $conson) and in_array(substr($syl, 0, 1), $conson)) continue;
			}
			// ajout aléatoire de chiffres
			$chiffres = rand(0, 2);
			for ($i=0; $i<$chiffres; $i++) {
				$syl .= rand(2, 9);
			}
			// traitement aléatoire de la casse
			if (rand(0, 1)) $syl = strtoupper($syl);
			if (rand(0, 1)) $syl = strtolower($syl);
			$pass .= $syl;
		}
		return substr($pass, 0, $length);
	} // end function getOne

	/**
	 Retourne une collection de mots de passe
	 @param num (int) nombre de mots de passe à générer (1)
	 @param (length) int nombre de caractères des mots de passe (8)
	 @return (array) : tableau de mots de passe générés par getOne.
	 */
	static public function getArray($num=1, $length=8) {
		if ($num < 1) $num = 1;
		$pass = array();
		for ($i=0; $i<$num; $i++) {
			$pass[] = Fast_Pass_Mnemo::getOne($length);
		}
		return $pass;
	} // end function getArray

	/**
	 Liste des syllabes utilisées pour générer les mots de passe.
	 */
	static public function getLex() {
		$lex = array(
				'ab', 'aba', 'abe', 'abu', 'ac', 'aca', 'ace', 'ach', 'acr', 'act', 'acu', 'ad',
				'ada', 'ade', 'adr', 'adu', 'af', 'afa', 'afe', 'afr', 'ag', 'aga', 'age', 'agr', 'aja', 'aje', 'aju', 'aka', 'ake',
				'aku', 'am', 'ama', 'amb', 'ame', 'amu', 'an', 'ana', 'anc', 'ane', 'ang', 'anr', 'ans', 'ant', 'anu', 'anv',
				'anx', 'any', 'anz', 'ap', 'apa', 'ape', 'apn', 'apr', 'aps', 'apu', 'apy', 'aq', 'aqu', 'ar', 'ara', 'arb', 'arc',
				'ard', 'are', 'arf', 'arg', 'arj', 'ark', 'arm', 'arn', 'arp', 'arq', 'arr', 'ars', 'art', 'aru', 'arv', 'arw',
				'arx', 'ary', 'arz', 'as', 'asa', 'asb', 'asc', 'asd', 'ase', 'asg', 'ash', 'ask', 'asm', 'asp', 'asq', 'ass',
				'ast', 'asu', 'asy', 'at', 'ata', 'atc', 'ate', 'atr', 'ats', 'atu', 'aty', 'au', 'aub', 'auc', 'aud', 'aue',
				'auf', 'aug', 'auj', 'aum', 'aun', 'aup', 'auq', 'aur', 'aus', 'aut', 'auv', 'auw', 'aux', 'auz', 'av', 'ava', 'ave',
				'avr', 'avu', 'awa', 'axa', 'axe', 'aya', 'aye', 'aym', 'ayn', 'ays', 'ayu', 'aza', 'aze', 'azu', 'azy',
				'ba', 'bab', 'bac', 'bad', 'baf', 'bag', 'bah', 'baj', 'bak', 'bam', 'ban', 'bap', 'baq', 'bar', 'bas', 'bat', 'bau',
				'bav', 'bay', 'baz', 'be', 'bea', 'bec', 'bed', 'bef', 'beg', 'beh', 'bek', 'bem', 'ben', 'ber', 'bes', 'bet', 'beu',
				'bey', 'bez', 'br', 'bra', 'bre', 'bru', 'bry', 'bu', 'bua', 'bub', 'buc', 'bud', 'bue', 'buf', 'bug',
				'buk', 'bum', 'bun', 'bup', 'buq', 'bur', 'bus', 'but', 'buv', 'buy', 'buz', 'byb', 'bye', 'bym', 'byq', 'byr',
				'bys', 'byt', 'byx', 'byz',
				'ca', 'cab', 'cac', 'cad', 'cae', 'caf', 'cag', 'cah', 'caj', 'cak', 'cam', 'can', 'cap', 'caq', 'car', 'cas', 'cat',
				'cau', 'cav', 'cay', 'caz', 'ce', 'cea', 'ceb', 'cec', 'cef', 'cem', 'cen', 'cep', 'ceq', 'cer', 'ces', 'cet', 'ceu',
				'cev', 'cez', 'ch', 'cha', 'chb', 'che', 'chu', 'chy', 'cr', 'cra', 'cre', 'cru', 'cry', 'cu', 'cua', 'cub', 'cuc',
				'cud', 'cue', 'cuf', 'cum', 'cun', 'cup', 'cur', 'cus', 'cut', 'cuv', 'cuy', 'cya', 'cyb', 'cyc', 'cyg', 'cym', 'cyn',
				'cyp', 'cyr', 'cys', 'cyt', 'cyx',
				'da', 'dab', 'dac', 'dad', 'daf', 'dag', 'dah', 'dak', 'dam', 'dan', 'dap', 'daq', 'dar', 'das', 'dat', 'dau', 'dav',
				'day', 'de', 'dea', 'deb', 'dec', 'ded', 'deg', 'deh', 'dem', 'den', 'dep', 'deq', 'der', 'des', 'det', 'deu', 'dev',
				'dex', 'dey', 'dez', 'dr', 'dra', 'dre', 'dru', 'dry', 'du', 'dua', 'dub', 'duc', 'due', 'dug', 'dum', 'dun', 'dup',
				'duq', 'dur', 'dus', 'dut', 'duv', 'dya', 'dyk', 'dym', 'dyn', 'dys', 'dyt',
				'eba', 'ebe', 'ebr', 'ebs', 'ebu', 'eca', 'ece', 'ech', 'ecr', 'ecu', 'ecy', 'eda', 'ede', 'edr', 'edu', 'efa', 'efe',
				'eff', 'efu', 'ega', 'ege', 'egr', 'egu', 'eja', 'eje', 'eke', 'ema', 'emu', 'emv', 'ena', 'enc', 'end', 'ene', 'enf',
				'eng', 'enj', 'enk', 'enq', 'enr', 'ens', 'ent', 'enu', 'env', 'enz', 'epa', 'epe', 'eph', 'epr', 'eps', 'epu', 'equ',
				'era', 'erb', 'erc', 'erd', 'ere', 'erf', 'erg', 'erj', 'erk', 'erm', 'ern', 'erp', 'erq', 'ers', 'ert', 'eru', 'erv',
				'ery', 'erz', 'esa', 'esb', 'esc', 'esd', 'ese', 'esg', 'esk', 'esm', 'esn', 'esp', 'esq', 'ess', 'est', 'esu', 'et',
				'eta', 'etc', 'ete', 'eth', 'etm', 'etn', 'etr', 'ets', 'etu', 'ety', 'eu', 'eub', 'euc', 'eud', 'eue', 'euf', 'eug',
				'euh', 'eum', 'eun', 'eup', 'euq', 'eur', 'eus', 'eut', 'euv', 'eux', 'euz', 'ev', 'eva', 'eve', 'evr', 'evs', 'evu',
				'evz', 'ewa', 'ewe', 'ex', 'exa', 'exc', 'exe', 'exu',
				'exy', 'eya', 'eyb', 'eye', 'eyf', 'eyn', 'eys', 'ez', 'eza', 'eze',
				'fa', 'fab', 'fac', 'fad', 'fae', 'faf', 'fag', 'fah', 'fak', 'fam', 'fan', 'faq', 'far', 'fas', 'fat', 'fau', 'fav',
				'fay', 'faz', 'fch', 'fe', 'fea', 'fec', 'fem', 'fen', 'fer', 'fes', 'fet', 'feu', 'fex', 'fez', 'fra', 'fre', 'fru',
				'fu', 'fub', 'fuc', 'fue', 'fug', 'fum', 'fun', 'fur', 'fus', 'fut', 'fuy',
				'ga', 'gab', 'gac', 'gad', 'gae', 'gaf', 'gag', 'gah', 'gam', 'gan', 'gap', 'gar', 'gas', 'gat', 'gau', 'gav', 'gaw',
				'gay', 'gaz', 'ge', 'gea', 'gem', 'gen', 'ger', 'ges', 'get', 'geu', 'gev', 'gey', 'gez', 'gna', 'gne', 'gns', 'gnu',
				'gr', 'gra', 'gre', 'gru', 'gry', 'gu', 'gua', 'gub', 'gue', 'gug', 'guh', 'gum', 'gun', 'gup', 'gur', 'gus', 'gut',
				'guy', 'guz', 'gya', 'gym', 'gyn', 'gyp', 'gyr',
				'ha', 'hab', 'hac', 'had', 'hae', 'haf', 'hag', 'hah', 'hak', 'ham', 'han', 'hap', 'haq', 'har', 'has', 'hat', 'hav',
				'haw', 'hay', 'haz', 'he', 'heb', 'hec', 'hed', 'hef', 'hek', 'hem', 'hen', 'hep', 'her', 'hes', 'het', 'heu', 'hev',
				'hex', 'hez', 'hu', 'hua', 'hub', 'huc', 'hue', 'hug', 'hum', 'hun', 'hup', 'hur', 'hus', 'hut', 'huy', 'hya', 'hyb',
				'hyc', 'hyd', 'hyg', 'hym', 'hyn', 'hyp', 'hyr', 'hys', 'hyt', 'hyx',
				'ja', 'jab', 'jac', 'jad', 'jaf', 'jag', 'jah', 'jaj', 'jak', 'jam', 'jan', 'jap', 'jaq', 'jar', 'jas', 'jat', 'jau',
				'jav', 'jax', 'jaz', 'je', 'jea', 'jeb', 'jec', 'jem', 'jen', 'jer', 'jes', 'jet', 'jeu', 'ju', 'jua', 'jub', 'juc',
				'jud', 'jug', 'juj', 'jum', 'jun', 'jup', 'jur', 'jus', 'jut', 'juv', 'jux',
				'kab', 'kac', 'kad', 'kaf', 'kag', 'kaj', 'kak', 'kam', 'kan', 'kap', 'kar', 'kas', 'kat', 'kav', 'kaw', 'kay', 'kaz',
				'keb', 'kef', 'ken', 'ker', 'kes', 'ket', 'keu', 'key', 'kra', 'kre', 'kry', 'kug', 'kum', 'kun', 'kur', 'kym', 'kyr',
				'kys', 'kyu',
				'ma', 'mab', 'mac', 'mad', 'mae', 'maf', 'mag', 'mah', 'maj', 'mak', 'mam', 'man', 'map', 'maq', 'mar', 'mas', 'mat',
				'mau', 'max', 'may', 'maz', 'me', 'mea', 'mec', 'med', 'meg', 'mem', 'men', 'meq', 'mer', 'mes', 'met', 'meu', 'mev',
				'mex', 'mez', 'mu', 'mua', 'muc', 'mud', 'mue', 'muf', 'mug', 'mum', 'mun', 'mup', 'muq', 'mur', 'mus', 'mut', 'mya',
				'myc', 'myd', 'myg', 'myr', 'mys', 'myt', 'myx',
				'na', 'nab', 'nac', 'nad', 'naf', 'nag', 'naj', 'nak', 'nam', 'nan', 'nap', 'naq', 'nar', 'nas', 'nat', 'nau', 'nav',
				'nax', 'nay', 'naz', 'ne', 'nea', 'neb', 'nec', 'ned', 'nef', 'nem', 'nen', 'nep', 'neq', 'ner', 'nes',
				'net', 'neu', 'nev', 'new', 'nex', 'ney', 'nez', 'nu', 'nua', 'nub', 'nuc', 'nud', 'nue', 'nuf', 'nug', 'num', 'nun',
				'nup', 'nuq', 'nur', 'nus', 'nut', 'nuy', 'nv', 'nyc', 'nym', 'nys', 'nyu', 'nyx',
				'pa', 'pab', 'pac', 'pad', 'pae', 'paf', 'pag', 'pah', 'paj', 'pak', 'pam', 'pan', 'pap', 'paq', 'par', 'pas', 'pat',
				'pau', 'pav', 'pax', 'pay', 'paz', 'pch', 'pe', 'pec', 'ped', 'peg', 'pem', 'pen', 'pep', 'per', 'pes', 'pet', 'peu',
				'pex', 'pey', 'pez', 'pha', 'phe', 'phu', 'phy', 'pr', 'pra', 'pre', 'pru', 'pry', 'ps', 'psa', 'pse', 'psu',
				'psy', 'pu', 'pua', 'pub', 'puc', 'pud', 'pue', 'puf', 'pug', 'puk', 'pum', 'pun', 'pup', 'pur', 'pus', 'put', 'puy',
				'puz', 'pya', 'pyc', 'pye', 'pyg', 'pyj', 'pyr', 'pyt', 'pyx',
				'qua', 'que',
				'ra', 'rab', 'rac', 'rad', 'raf', 'rag', 'rah', 'raj', 'rak', 'ram', 'ran', 'rap', 'raq', 'rar', 'ras', 'rat', 'rau',
				'rav', 'raw', 'rax', 'ray', 'raz', 're', 'reb', 'rec', 'red', 'ref', 'reg', 'reh', 'rej', 'rem', 'ren', 'rep', 'req',
				'rer', 'res', 'ret', 'reu', 'rev', 'rew', 'rex', 'rey', 'rez', 'rhe', 'rhu', 'rhy', 'ru', 'rua', 'rub', 'ruc', 'rud',
				'rue', 'ruf', 'rug', 'rum', 'run', 'rup', 'ruq', 'rur', 'rus', 'rut', 'ruv', 'rux', 'ruy', 'ruz', 'rya', 'ryb', 'ryc',
				'rye', 'ryg', 'ryh', 'rym', 'ryn', 'ryp', 'rys', 'ryt', 'ryu', 'ryx', 'ryz',
				'sa', 'sab', 'sac', 'sad', 'saf', 'sag', 'sah', 'saj', 'sak', 'sam', 'san', 'sap', 'saq', 'sar', 'sas', 'sat', 'sau',
				'sav', 'sax', 'say', 'scu', 'se', 'sec', 'sed', 'sef', 'seg', 'sek', 'sem', 'sen', 'sep', 'seq', 'ser', 'ses', 'set',
				'seu', 'sev', 'sey', 'sez', 'sfa', 'sfe', 'sfu', 'sha', 'she', 'shu', 'shy', 'ska', 'ske', 'sku', 'sky', 'sma',
				'sme', 'smu', 'smy', 'sna', 'sne', 'spa', 'spe', 'spu', 'squ', 'sra', 'sta', 'ste', 'stu', 'sty', 'su', 'sub', 'suc',
				'sud', 'suf', 'sug', 'suj', 'sum', 'sun', 'sup', 'sur', 'sus', 'sut', 'suv', 'suy', 'suz', 'syb', 'syc', 'syd', 'sym',
				'syn', 'syp', 'syr', 'sys', 'syt', 'syu', 'syz',
				'ta', 'tab', 'tac', 'tad', 'taf', 'tag', 'tah', 'taj', 'tak', 'tam', 'tan', 'tap', 'taq', 'tar', 'tas', 'tat', 'tav',
				'tax', 'tay', 'taz', 'te', 'tea', 'teb', 'tec', 'ted', 'tef', 'teg', 'tem', 'ten', 'tep', 'teq', 'ter', 'tes', 'tet',
				'teu', 'tev', 'tew', 'tex', 'tez', 'tr', 'tra', 'tre', 'tru', 'try', 'tsa', 'tsu', 'tsy', 'tu', 'tua', 'tub', 'tuc',
				'tud', 'tuf', 'tug', 'tuk', 'tum', 'tun', 'tup', 'tuq', 'tur', 'tus', 'tut', 'tuv', 'tuy', 'tya', 'tyg', 'tym', 'typ',
				'tyq', 'tyr', 'tys', 'tyv', 'tyx', 'tza', 'tze',
				'ua', 'uab', 'uac', 'uad', 'uag', 'uah', 'uak', 'uam', 'uan', 'uap', 'uaq', 'uar', 'uas', 'uat', 'uau', 'uav', 'uaw',
				'uay', 'ub', 'uba', 'ubc', 'ubd', 'ube', 'ubu', 'uc', 'uca', 'uce', 'uch', 'uck', 'ucr', 'ucs', 'uct', 'ucu', 'ud',
				'uda', 'ude', 'udr', 'uds', 'udu', 'uem', 'uen', 'uep', 'uer', 'ues', 'uet', 'ueu', 'uev', 'uez', 'uf', 'ufa', 'ufe',
				'uga', 'uge', 'ugh', 'ugr', 'ugu', 'uja', 'uje', 'uju', 'uka', 'ukr', 'uks', 'uku', 'um', 'uma', 'ume', 'umu',
				'un', 'una', 'unc', 'und', 'une', 'ung', 'unk', 'unr', 'uns', 'unt', 'unu', 'up', 'upa', 'upe', 'uph', 'upr', 'ups',
				'upt', 'upu', 'uqu', 'ur', 'ura', 'urb', 'urc', 'urd', 'ure', 'urf', 'urg', 'urh', 'urj', 'urk', 'urm', 'urn', 'urp',
				'urq', 'urs', 'urt', 'uru', 'urv', 'ury', 'us', 'usa', 'usb', 'usc', 'usd', 'use', 'ush', 'usk', 'usm', 'usn', 'usp',
				'ust', 'usu', 'usv', 'ut', 'uta', 'ute', 'utr', 'uts', 'utu', 'uty', 'utz', 'uv', 'uva', 'uve', 'uvr', 'ux',
				'uxa', 'uxe', 'uxt', 'uxu', 'uza', 'uze', 'uzy',
				'va', 'vab', 'vac', 'vad', 'vag', 'vaj', 'vam', 'van', 'vap', 'vaq', 'var', 'vas', 'vat', 'vau', 'vav', 've', 'vea',
				'vec', 'ved', 'veg', 'vem', 'ven', 'ver', 'ves', 'vet', 'veu', 'vex', 'vez', 'vra', 'vre', 'vu', 'vue', 'vum', 'vun',
				'vur', 'vus', 'vut',
				'wag', 'wah', 'wam', 'wan', 'wap', 'war', 'was', 'wat', 'wax', 'way', 'wed', 'weg', 'wer', 'wes',
				'xab', 'xac', 'xaf', 'xag', 'xam', 'xan', 'xar', 'xas', 'xat', 'xau', 'xe', 'xem', 'xen', 'xeq', 'xer', 'xes', 'xeu',
				'xez', 'xua', 'xub', 'xur', 'xus', 'xut', 'xyc', 'xyd', 'xyg', 'xyh', 'xym', 'xyr', 'xys', 'xyu',
				'yab', 'yac', 'yad', 'yag', 'yak', 'yam', 'yan', 'yar', 'yas', 'yat', 'yau', 'yav', 'yaw', 'ybe', 'yea', 'yem', 'yen',
				'yer', 'yes', 'yet', 'yeu', 'yez', 'ygy', 'yra', 'yre', 'yru', 'yry', 'ysu', 'ysy', 'yta', 'yte', 'ytu', 'yty', 'yua',
				'yuc', 'yum', 'yun', 'yur', 'yva', 'yve', 'yza', 'yzy',
				'zab', 'zac', 'zad', 'zag', 'zak', 'zan', 'zar', 'zas', 'zay', 'zaz', 'zbe', 'zda', 'zeb', 'zef', 'zem', 'zen', 'zep',
				'zer', 'zes', 'zet', 'zeu', 'zue', 'zup', 'zur', 'zut', 'zyg', 'zym', 'zyt'
		);
		// mélange du lexique final
		shuffle($lex);
		return $lex;
	} // fin function getLex
}
?>
<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
class home extends \framework\page {
	function title() {
		return "Home";
	}
	
	function action_def() {
$samplecode = <<<'SAMPLE'
<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
class index extends \framework\page {
	function title() {
		return "Home";
	}

	function action_def() {
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg"));
		$cont->add(new element("h1",array(),"Ciao!!" ));		
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->add(new anchorbutton("customers", "Vedi clienti",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->add(new anchorbutton("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		app::Controller()->addMessage("Benvenuto!!");
		return $cont;
	}
}
SAMPLE;
$samplecode2 = <<<'SAMPLE2'
<code><span style="color: #000000">
<span style="color: #0000BB">&lt;?php<br></span><span style="color: #007700;">namespace&nbsp;</span><span style="color: #0000BB;">views</span><span style="color: #007700;">;<br>use&nbsp;\</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">html</span><span style="color: #007700;">\</span><span style="color: #0000BB;">anchor</span><span style="color: #007700;">;<br>use&nbsp;</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">html</span><span style="color: #007700;">\</span><span style="color: #0000BB;">element</span><span style="color: #007700;">;<br>use&nbsp;</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">html</span><span style="color: #007700;">\</span><span style="color: #0000BB;">img</span><span style="color: #007700;">;<br>use&nbsp;</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">app</span><span style="color: #007700;">;<br>use&nbsp;</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">html</span><span style="color: #007700;">\</span><span style="color: #0000BB;">anchorbutton</span><span style="color: #007700;">;<br>class&nbsp;</span><span style="color: #0000BB;">index&nbsp;</span><span style="color: #007700;">extends&nbsp;\</span><span style="color: #0000BB;">framework</span><span style="color: #007700;">\</span><span style="color: #0000BB;">page<br></span><span style="color: #007700;">{<br>&nbsp;&nbsp; &nbsp;function&nbsp;</span><span style="color: #0000BB;">title</span><span style="color: #007700;">()<br>&nbsp;&nbsp; &nbsp;{<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;return&nbsp;</span><span style="color: #DD0000;">"Home"</span><span style="color: #007700;">;<br>&nbsp;&nbsp; &nbsp;}<br>&nbsp;&nbsp; &nbsp;<br>&nbsp;&nbsp; &nbsp;function&nbsp;</span><span style="color: #0000BB;">action_def</span><span style="color: #007700;">()<br>&nbsp;&nbsp; &nbsp;{<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont&nbsp;</span><span style="color: #007700;">=&nbsp;new&nbsp;</span><span style="color: #0000BB;">element</span><span style="color: #007700;">(</span><span style="color: #DD0000;">""</span><span style="color: #007700;">);<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">img</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"minifwlogo.jpg"</span><span style="color: #007700;">));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">element</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"h1"</span><span style="color: #007700;">,&nbsp;array(),&nbsp;</span><span style="color: #DD0000;">"Ciao!!"</span><span style="color: #007700;">));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">element</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"p"</span><span style="color: #007700;">,&nbsp;array(),&nbsp;</span><span style="color: #0000BB;">file_get_contents</span><span style="color: #007700;">(</span><span style="color: #0000BB;">__DIR__&nbsp;</span><span style="color: #007700;">.&nbsp;</span><span style="color: #DD0000;">"/../lib/home.txt"</span><span style="color: #007700;">)));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">anchorbutton</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"customers"</span><span style="color: #007700;">,&nbsp;</span><span style="color: #DD0000;">"Vedi&nbsp;clienti"</span><span style="color: #007700;">,&nbsp;array(<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #DD0000;">"class"&nbsp;</span><span style="color: #007700;">=&gt;&nbsp;</span><span style="color: #DD0000;">"button"<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #007700;">)));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">element</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"p"</span><span style="color: #007700;">,&nbsp;array(),&nbsp;</span><span style="color: #0000BB;">file_get_contents</span><span style="color: #007700;">(</span><span style="color: #0000BB;">__DIR__&nbsp;</span><span style="color: #007700;">.&nbsp;</span><span style="color: #DD0000;">"/../lib/home.txt"</span><span style="color: #007700;">)));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">anchorbutton</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"orders"</span><span style="color: #007700;">,&nbsp;</span><span style="color: #DD0000;">"Vedi&nbsp;Ordini"</span><span style="color: #007700;">,&nbsp;array(<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #DD0000;">"class"&nbsp;</span><span style="color: #007700;">=&gt;&nbsp;</span><span style="color: #DD0000;">"button"<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #007700;">)));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">-&gt;</span><span style="color: #0000BB;">add</span><span style="color: #007700;">(new&nbsp;</span><span style="color: #0000BB;">element</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"p"</span><span style="color: #007700;">,&nbsp;array(),&nbsp;</span><span style="color: #0000BB;">file_get_contents</span><span style="color: #007700;">(</span><span style="color: #0000BB;">__DIR__&nbsp;</span><span style="color: #007700;">.&nbsp;</span><span style="color: #DD0000;">"/../lib/home.txt"</span><span style="color: #007700;">)));<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color: #0000BB;">app</span><span style="color: #007700;">::</span><span style="color: #0000BB;">Controller</span><span style="color: #007700;">()-&gt;</span><span style="color: #0000BB;">addMessage</span><span style="color: #007700;">(</span><span style="color: #DD0000;">"Benvenuto!!"</span><span style="color: #007700;">);<br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;return&nbsp;</span><span style="color: #0000BB;">$cont</span><span style="color: #007700;">;<br>&nbsp;&nbsp; &nbsp;}<br>}</span>
</span>
</code>
SAMPLE2;
		app::Controller()->addMessage("Benvenuto!!");
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg"));
		$cont->add(new element("h1",array(),"Ciao!!" ));		
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->add(new anchorbutton("customers", "Vedi clienti",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->add(new anchorbutton("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$code = new element("div",[],$samplecode2,TRUE);
		$cont->add([new element("h3",[],"Il codice necessario per questa pagina:"), $code]);
		return $cont;
	}

}

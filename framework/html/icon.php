<?php
/**
 *
 * icon.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html;
	use framework\app;
	/**
	 * icon
	 *
	 * Genera un tag immagine specifico per una delle icone presenti nella cartella /img/icons/*.png<br>
	 * Esempio:
	 * <code>
	 * use framework\html\icon;
	 * $iconIn = new icon("ZoomIn");
	 * $iconOut = new icon("ZoomOut");
	 * </code>
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 * @see element
	 *
	 */

	class icon extends element {
		/**
		 * Costruttore
		 *
		 * @param string $icon Nome immagine senza percorso ed estensione
		 */
		function __construct($icon) {
			$this->tag = "img";
			$this->attr = array("src" => app::root()."img/icons/$icon.png");
			$this->addAttr("style", "vertical-align: sub;");
		}
	}


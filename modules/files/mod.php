<?php
class filesMod extends module {
	public function connectDragDropAssets() {
		document::_()->addScript('filedrop-min');
	}
}
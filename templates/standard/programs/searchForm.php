<form action="<?php echo rs('programs.getSearchAction')?>" method="get">
	<div class="form-search search-only">
		<i class="search-icon glyphicon glyphicon-search"></i>
		<input required type="text" name="s" class="form-control search-field search-query" placeholder="<?php lang::_e('SEARCH_PLACEHOLDER')?>" value="<?php echo empty($this->searched) ? '' : $this->searched?>" />
		<input type="submit" value="<?php lang::_e('SEARCH')?>" />
	</div>
</form>
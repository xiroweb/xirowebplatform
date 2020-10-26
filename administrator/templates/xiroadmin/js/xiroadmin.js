jQuery(function($)
{
	/** Set local storage if expaneded **/
	/* https://github.com/ColorlibHQ/AdminLTE/issues/1240#issuecomment-526489073 */
	$('body').bind('expanded.pushMenu', function(e){
		$('.hide-collapse-form').show();
		localStorage.setItem("comercial_sidebar","expanded");
	});

	/** Set local storage if collapsed **/
	$('body').bind('collapsed.pushMenu', function(e){
		$('.hide-collapse-form').hide();
		localStorage.setItem("comercial_sidebar","collapsed");
	});

	/** Retrieve local storage value and change class of body **/
	if(localStorage.getItem("comercial_sidebar") !== null) {
		if(localStorage.getItem("comercial_sidebar") === 'collapsed') {
			$('.hide-collapse-form').hide();
			$("body").addClass('sidebar-collapse');
		}
	}
});

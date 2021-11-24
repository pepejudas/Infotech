//<![CDATA[

// The instanceReady event is fired when an instance of CKEditor has finished
// its initialization.

try{
function InsertHTML(txt)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	
	// Check the active editing mode.
	if ( oEditor.mode == 'wysiwyg' )
	{
		// Insert the desired HTML.
		oEditor.insertHtml( txt );
	}
	else
		alert( 'You must be on WYSIWYG mode!' );
}
function limpiarEd(){

	Sexy.confirm('Desea eliminar todo el contenido del editor?', {
		  onComplete:
		    function(returnvalue) {
		      if (returnvalue) {
		        SetContents("");
		      }
		    }
		  });
}
function SetContents(txt)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Set the editor contents (replace the actual one).
	oEditor.setData( txt );
}

function GetContents()
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Get the editor contents
	return oEditor.getData();
}

function ExecuteCommand(commandName)
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Check the active editing mode.
	if ( oEditor.mode == 'wysiwyg' )
	{
		// Execute the command.
		oEditor.execCommand( commandName );
	}
	else
		alert( 'You must be on WYSIWYG mode!' );
}

function CheckDirty()
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;
	alert( oEditor.checkDirty() );
}
}catch(er){
alert(er);	
	
}
	//]]>

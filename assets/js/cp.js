if(document.getElementsByClassName) 
{
	getElementsByClass = function(classList, node) { return (node || document).getElementsByClassName(classList); }
	
} else 
{
	getElementsByClass = function(classList, node) 
	{        
		var node = node || document,
				list = node.getElementsByTagName('*'),
				length = list.length, 
				classArray = classList.split(/\s+/),
				classes = classArray.length,
				result = [], i,j;
		
		for(i = 0; i < length; i++)
			for(j = 0; j < classes; j++) 
				if(list[i].className.search('\\b' + classArray[j] + '\\b') != -1)
				{
					result.push(list[i]);
					break;
				}
		
		return result;
	}
}

var oProtect = getElementsByClass('protect'),
		oNotProtect = getElementsByClass('no-protect');

var iProtect = oProtect.length,
		iNotProtect = oNotProtect.length;		

for(var i = 0; i < iProtect; i++)
{
	oProtect[i].ondragstart = catchControlKeys;
	
	oProtect[i].onselectstart = catchControlKeys;
	
	oProtect[i].oncopy = catchControlKeys;
	
	oProtect[i].oncontextmenu = catchControlKeys;
	
	oProtect[i].onkeypress = catchControlKeys;
}

for(var i = 0; i < iNotProtect; i++)
{
	oNotProtect[i].ondragstart = disableProtection;
	
	oNotProtect[i].onselectstart = disableProtection;
	
	oNotProtect[i].oncopy = disableProtection;
	
	oNotProtect[i].oncontextmenu = disableProtection;
	
	oNotProtect[i].onkeypress = disableProtection;
}

function disableProtection(event)
{
	e = event || window.event;
	e.stopPropagation();
	return true;
}

function catchControlKeys(evn)
{
	event = evn || window.event;
	
	var aRestrict = [117, 85, 99, 67, 97, 65];
	/*117, 85 ctrl+u 99, 67 ctrl+c 97, 65 ctrl+a*/
	
	if(aRestrict.indexOf(getKeyCode(event)) >= 0)
		return false;
		
	else if(event.type == 'dragstart' || event.type == 'selectstart' || event.type == 'contextmenu'  || event.type == 'copy')
		return false;
		
	return true;
}

function getKeyCode(e)
{
	var iCode = e.keyCode;
	
	if(!iCode)
		iCode = e.which;

	return iCode;
}

function checkProtection(element)
{
	if(typeof(element) == 'undefined' || !element || element.nodeName.toLowerCase() == 'body')
		return true;
	
	var sClassName = element.className,
			parent = element.parentNode;
			
	if(typeof(sClassName) == 'undefined' || sClassName == '')
	{
		if(parent)
			return checkProtection(parent);
		else
			return true;
				
	}else if(sClassName.split(' ').indexOf('protect') >= 0)
		return true;
		
	else if(sClassName.split(' ').indexOf('no-protect') >= 0)	
			return false;	
	else if(parent)
			return checkProtection(parent);
		
	return true;	
}
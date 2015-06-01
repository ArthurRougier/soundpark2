var asideLinks = document.querySelectorAll('aside ul li a');
for(var indexDivs = 0 ; indexDivs < asideLinks.length ; indexDivs++)
{
	asideLinks[indexDivs].addEventListener('click', function() {
		var correspondingContainer = document.getElementById('tab'+this.id.slice(-1));
		correspondingContainer.className="show";
		containerSibblings = getSiblings(correspondingContainer);
		for(indexContainers = 0 ; indexContainers <  containerSibblings.length ; indexContainers ++)
		{
			getSiblings(correspondingContainer)[indexContainers].className="hidden";
		}
		styleAsideLink(this);	
	}, false);
}


function styleAsideLink(div)
{
	var sibblings = getSiblings(div.parentNode);
	

	div.style.borderLeft="8px solid #531931";
	div.parentNode.style.boxShadow="0 0 0 1px rgb(232, 232, 232) inset";
	div.parentNode.style.backgroundColor="rgba(83, 25, 49, 0.05)";


	for(indexSibblings = 0 ; indexSibblings<sibblings.length ; indexSibblings++)
	{
		
		sibblings[indexSibblings].firstChild.style.borderLeft="";
		sibblings[indexSibblings].style.backgroundColor="";
		sibblings[indexSibblings].style.boxShadow="";
	}

}

function getChildren(n, skipMe){
    var r = [];

    for ( ; n; n = n.nextSibling ) {
            if ( n.nodeType === 1 && n !== skipMe ) {
                r.push( n );
            }
        }

    return r;
}

function getSiblings(n) {
    return getChildren(n.parentNode.firstChild, n);
}

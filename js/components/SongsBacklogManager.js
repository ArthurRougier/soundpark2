export default class SongsBacklogManager extends React.Component {
	render() {
	    return (
	    	<div id="body">
				<aside>
					<ul>
					  <li><Link to="/new">New</Link></li>
			          <li><Link to="/used">Used</Link></li>
			          <li><Link to="/storage">Storage</Link></li>
					</ul>
				</aside>
				<div id="container">
					{this.props.children}
				</div>
			</div>
	    )
	  }
}
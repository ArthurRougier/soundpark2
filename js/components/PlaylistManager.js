export default class PlaylistManager extends React.Component {
	render() {
	    return (
    	<div id="body">
			<aside>
				<ul>
				  <li><Link to="/current">Current</Link></li>
				  <li><Link to="/n+1">Next one</Link></li>
				</ul>
			</aside>
			<div id="container">
				{this.props.children}
			</div>
		</div>
	    )
	  }
}
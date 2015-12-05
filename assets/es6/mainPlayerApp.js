var Player       = require('./player3.js');
var Liker         = require('./Liker.js');

// React and react router
import React from 'react';
import ReactDOM from 'react-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

SC.initialize({
      client_id: "17f3a8c69cb36c955df82f908611e27e"
  });


$.ajax({
  url: "../model/get_player_songs.php?playlistId=69&displayResults",
  dataType: 'json',
  cache: false,
  
  success: function(trackListEntry) {
    var arrowSelectors        = ["#left_arrow", "#right_arrow"];
    var likeDislikeSelectors  = ["#plus_one", "#minus_one"];
    var trackList             = trackListEntry.filter(function(n){ return n != "" }); 
    trackList = trackList.filter(function(item, pos) {
      return trackList.indexOf(item) == pos;
    })
    var playerTest            = new Player(trackList, '.slider', '.play', arrowSelectors);
    setTimeout(function(){
      var likerTest             = new Liker(likeDislikeSelectors, playerTest);
      console.log(playerTest);}, 3000); 
  }.bind(this),

  error: function(xhr, status, err) {
    console.error("kjbkj", status, err.toString());
  }.bind(this)
});

class DropDownMenu extends React.Component {

  constructor (props) {
    super(props);
    this.state = {
      isDisplayed     : false,
      userName        : "",
      isCurator       : true,
      userAvatarUrl   : ""
    };

     this.handleUrlChange     = this.handleUrlChange.bind(this);
     this.loadUserPseudo      = this.loadUserPseudo.bind(this);
     this.loadUserAvatar      = this.loadUserAvatar.bind(this);
     this.loadUserType        = this.loadUserType.bind(this);
  }

  handleUrlChange(e) {
    this.setState({isDisplayed: !this.state.isDisplayed});
  }

  loadUserPseudo() {
    $.ajax({
      url: "../model/get_user_complete_name.php?displayResult=TRUE",
      cache: false,

      success: function(userPseudo) {
        console.log("Pseudo Loaded: " + userPseudo);
        this.setState({userName: userPseudo});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_complete_name.php?displayResult=TRUE", status, err.toString());
      }.bind(this)
    });
  }

  loadUserAvatar() {
    $.ajax({
      url: "../model/get_user_facebook_picture.php?displayResult=TRUE",
      cache: false,

      success: function(avatarUrl) {
        console.log("Avatar url: " + avatarUrl);
        this.setState({userAvatarUrl: avatarUrl});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_facebook_picture.php?displayResult=TRUE", status, err.toString());
      }.bind(this)
    });
  }

  loadUserType() {
    $.ajax({
      url: "../model/get_user_type.php?displayResult=TRUE",
      cache: false,

      success: function(userType) {
        console.log("userType: "+ userType);
        parseInt(userType) == 2 ? this.setState({isCurator: true}) : this.setState({isCurator: false});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_type.php?displayResult=TRUE", status, err.toString());
      }.bind(this)
    });
  }

  componentDidMount() {
    this.handleUrlChange(); 
    this.loadUserPseudo();
    this.loadUserAvatar();
    this.loadUserType();
  }

  render() {  

  var pseudo      = this.state.userName.length > 13 ? this.state.userName.substring(0, 13) : this.state.userName;
  var imagetag    = this.state.userAvatarUrl ? <img id="toggler" src={this.state.userAvatarUrl}/>  : <div id="togglerDiv">{this.state.userName.substring(0, 1).toUpperCase()}</div>;
  var secondLink  = this.state.isCurator ? <li><a href="../view/curator_index.php" target="_blank">Curator space</a></li> : <li><a href="#" onclick="curatorPopup()">Become a curator</a></li>;

  return (
     <div className="container-dropdown">
        <ul>
          <li className="dropdown">
            <input type="checkbox" id="dropdownCheckbox" onChange={this.handleChange} />
            <a href="#" data-toggle="dropdown">
              {pseudo}
              {imagetag}        
            </a>
            <ul className="account-dropdown-menu">
              {secondLink}
              <li><a href="../view/settings.php" target="_blank">My account</a></li>
              <li><a href="../control/logout.php">Log out</a></li>
            </ul>
         </li>
        </ul>
     </div>
      )
    }
}

class CuratorPannelText extends React.Component {
  render() {
    if(this.props.isDisplayed)
    {
      var pannel = <div id="left-pannel"><h1> Hello lzala </h1></div>;
    }
    else
    {
     var pannel = "";
    }
    console.log('isrendered, isDisplayed: '+ this.props.isDisplayed);
      return (
        <ReactCSSTransitionGroup transitionName="example" transitionEnterTimeout={500} transitionLeaveTimeout={300}>
          {pannel}
        </ReactCSSTransitionGroup>
      )
    }
}



ReactDOM.render(
  <DropDownMenu />,
    document.getElementById('extraOptions')
);
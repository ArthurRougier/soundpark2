var Player       = require('./player3.js');
var Liker         = require('./Liker.js');

// React and react router
import React from 'react';
import ReactDOM from 'react-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

//Curator former pop up
import curatorPopup from '../../assets/popUps';

//Import statement:
import Tabs from '../../node_modules/material-ui/lib/tabs/tabs';
import Tab from '../../node_modules/material-ui/lib/tabs/tab';
import TextField from '../../node_modules/material-ui/lib/text-field';
import FlatButton from '../../node_modules/material-ui/lib/flat-button';

//For curators tracks table
import Table from 'material-ui/lib/table/table';
import TableBody from 'material-ui/lib/table/table-body';
import TableFooter from  'material-ui/lib/table/table-footer';
import TableHeader from 'material-ui/lib/table/table-header';
import TableHeaderColumn from 'material-ui/lib/table/table-header-column';
import TableRow from 'material-ui/lib/table/table-row';
import TableRowColumn from 'material-ui/lib/table/table-row-column';

import ThemeManager from 'material-ui/lib/styles/theme-manager';
import MyRawTheme from 'material-ui/lib/styles/raw-themes/dark-raw-theme';

import urlValidityTester from '../../js/player_modules/urlValidityTester';

import ThemeDecorator from 'material-ui/lib/styles/theme-decorator';


let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

SC.initialize({
      client_id: "17f3a8c69cb36c955df82f908611e27e"
  });


$.ajax({
  url: "../model/get_player_songs.php?playlistId=current&displayResults",
  dataType: 'json',
  cache: false,
  
  success: function(trackListEntry) {
    var arrowSelectors        = ["#left_arrow", "#right_arrow"];
    var likeDislikeSelectors  = ["#plus_one", "#minus_one"];
    var trackList             = trackListEntry.filter(function(n){ return n != "" }); 
    trackList = trackList.filter(function(item, pos) {
      return trackList.indexOf(item) == pos;
    })
    var playerTest            = new Player(trackList, '.slider', '.play', arrowSelectors, true);
    setTimeout(function(){
      var likerTest           = new Liker(likeDislikeSelectors, playerTest);
      console.log(playerTest);
    }, 3000); 
  }.bind(this),

  error: function(xhr, status, err) {
    console.error("kjbkj", status, err.toString());
  }.bind(this)
});

class DropDownMenu extends React.Component {

  constructor (props) {
    super(props);
    this.state = {
      isDisplayed                   : false,
      isPanelDisplayed              : false,
      userName                      : "",
      isCurator                     : false,
      userAvatarUrl                 : "",
      curatorFormSuccessMessage     : false,
      curatorFormFailMessage        : false,
      userId                        : "",
      curatorId                     : "",
      trackListLikedSongs           : [],
      trackListLikedSongsProper     : [],
      isLoadedLikedSongs            : false,
      trackListCuratorBacklog       : [],
      trackListCuratorBacklogProper : [],
      isCuratorBacklogLoaded        : false
    };
  }

  static get childContextTypes() {
         let validators: React.ValidationMap = {
             muiTheme: React.PropTypes.object
         }
         return validators
     }
     getChildContext() {
         return {
              muiTheme: ThemeManager.getMuiTheme(MyRawTheme)
         };
     }

  handleChange = (e) => {
    this.setState({isDisplayed: !this.state.isDisplayed});
    //console.log(e);
  }

  handlePanelClick = () => {
    if(!this.state.isCurator && !this.state.isLoadedLikedSongs)
    {
      this.loadLikedTracksFromServer();
    }
    this.setState({isPanelDisplayed: !this.state.isPanelDisplayed});
    this.setState({isDisplayed: !this.state.isDisplayed});

  }

  closePanel = () => {
    this.setState({isPanelDisplayed: false});
  }

  handleCuratorFormSuccess = () => {
    this.setState({curatorFormSuccessMessage: true});
    this.setState({curatorFormFailMessage: false});
    setTimeout(function(){this.setState({curatorFormSuccessMessage: false})}.bind(this), 2000);

  }

  handleCuratorFormFail = () => {
    this.setState({curatorFormFailMessage: true});
    setTimeout(function(){this.setState({curatorFormFailMessage: false})}.bind(this), 4000);
  }

  loadUserPseudo = () => {
    $.ajax({
      url: "../model/get_user_complete_name.php?displayResult=TRUE",
      cache: false,

      success: function(userPseudo) {
        //console.log("Pseudo Loaded: " + userPseudo);
        this.setState({userName: userPseudo});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_complete_name.php?displayResult=TRUE", status, err.toString());
      }.bind(this)
    });
  }

  loadUserAvatar = () => {
    $.ajax({
      url: "../model/get_user_facebook_picture.php?displayResult=TRUE",
      cache: false,

      success: function(avatarUrl) {
        //console.log("Avatar url: " + avatarUrl);
        this.setState({userAvatarUrl: avatarUrl});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_facebook_picture.php?displayResult=TRUE", status, err.toString());
      }.bind(this)
    });
  }

  loadUserType = () => {
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

  loadUserId = () => {
    $.ajax({
      url: "../model/get_user_id.php?displayResults=TRUE",
      cache: false,

      success: function(userId) {
        //console.log("userId: "+ userId);
        this.setState({userId: userId});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_user_id.php?displayResults=TRUE", status, err.toString());
      }.bind(this)
    });
  }


  loadCuratorId = () => {
    $.ajax({
      url: "../model/get_curator_id.php?displayResults",
      cache: false,

      success: function(userId) {
        //console.log("CuratorId: "+ userId);
        this.setState({curatorId: userId});
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../model/get_curator_id.php?displayResults", status, err.toString());
      }.bind(this)
    });
  }

  // liked tracks component Logic

  loadLikedTracksFromServer = () => {
      $.ajax({
        url: '../model/get_settings_song_tiles.php?displayResults',
        dataType: 'json',
        cache: false,
        success: function(trackList) {
          if(JSON.stringify(trackList) !=  JSON.stringify(this.state.trackList))
          {
            this.setState({trackListLikedSongs: trackList});
            this.getTrackInfo(this.state.trackListLikedSongs);
          }
        }.bind(this),
        error: function(xhr, status, err) {
          console.error('/model/get_curators_week_songs.php?curatorId=', status, err.toString());
        }.bind(this)
      });
  }

  getTrackInfo = (trackListUrl) => {

      var that                  = this;
      var ajaxRequestNumber     = 0;
      var ajaxRequestCompleted  = 0;
      var trackListProper       = this.state.trackListLikedSongs;

      for(var indexTrackList  = 0, trackListLength = trackListUrl.length ; indexTrackList < trackListLength ; indexTrackList++)
      {
        var urlCopy = trackListUrl[indexTrackList].url;
        //console.log(indexTrackList + " url: " + urlCopy);

        if(urlCopy.toLowerCase().indexOf("youtube") > -1 )
        {
          urlValidityTester(urlCopy, function(result){
            var trackIdCopy = result;
            (function(trackIdCopy, indexTrackList){

                           $.ajax({
                              url: "https://www.googleapis.com/youtube/v3/videos?id="+ trackIdCopy +"&key=AIzaSyAzc_ihjBq03TOwwPqkt1ZgfT6ouEJ5plI&part=snippet",
                              dataType: 'json',
                              cache: false,
                              success: function(song) {
                                trackListProper[indexTrackList].title       = song.items[0].snippet.title;
                                trackListProper[indexTrackList].coverUrl    = "http://img.youtube.com/vi/" + trackIdCopy + "/hqdefault.jpg";

                                if(isFinished(indexTrackList))
                                {
                                  that.setState({trackListLikedSongsProper: trackListProper, isLoadedLikedSongs: true});
                                  console.log("Tracklist after all calls: ");
                                  console.log(that.state.trackListLikedSongsProper);
                                  //callBack();
                                } 
                                //console.log(trackListProper);
                              }.bind(this),
                              error: function(xhr, status, err) {
                                console.error("https://www.googleapis.com/youtube/v3/videos?id=", status, err.toString());
                              }.bind(this)
                            });
            })(trackIdCopy, indexTrackList);
          }.bind(this));
          ajaxRequestNumber++;
        }

        else if(urlCopy.toLowerCase().indexOf("soundcloud") > -1 ){


          (function(urlCopy, indexTrackList){
            //console.log(urlCopy);
            SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
            {
              if(track)
              {
                trackListProper[indexTrackList].title  = track.title;
                trackListProper[indexTrackList].coverUrl =  track.artwork_url ? track.artwork_url.replace("large.jpg", "t300x300.jpg") : "../assets/pictures/default_cover.png";
              }

              if(isFinished(indexTrackList))
              {
                //that.trackList = trackListProper;
                that.setState({trackListLikedSongsProper: trackListProper, isLoadedLikedSongs: true});
                console.log("Tracklist after all calls: ");
                console.log(that.state.trackListLikedSongsProper);
                //callBack();
              } 
            });
          })(urlCopy, indexTrackList);
          ajaxRequestNumber++;
      }
    }
    var isFinished = function(index){
      ajaxRequestCompleted++;
      //console.log('Ajax Req Number L: ' + ajaxRequestNumber);
      //console.log('Ajax Req Completed L: ' + ajaxRequestCompleted);
      if(ajaxRequestCompleted === ajaxRequestNumber){
        console.log('completed! Launching callback...');
        return true;
      }
    }
  }


  // SubmitTracksForm logic

  handleCuratorUrlSubmit = (e, url) => {
      e.preventDefault();
      var url         = url.trim();
      var curatorId   = this.state.curatorId;
      //console.log("Sending to playlist: "+ url + "by curator: " + curatorId);
      if (!url || !curatorId) {
        console.log('Problem, no url of no curator. url: '+url);
        return;
      }
      //this.props.onCommentSubmit({url: url, curator: curator});
      urlValidityTester(url,function(result){
        //console.log("launching ajax call to: ../model/store_new_track.php?url="+url+"&curatorId="+curatorId+"&treated=1&playlistId="+playlistId);
        if(result)
        {
          var urlEncoded= encodeURIComponent(url);
          $.ajax({
          url: "../model/store_new_track.php?url="+urlEncoded+"&curatorId="+curatorId,
          cache: false,
          success: function(resultAjax) {
            //this.setState({url: ""});
            this.handleCuratorFormSuccess();
            this.loadCuratorsSongsFromServer();
            console.log('Track successfully stored in backlog');
          }.bind(this),
          error: function(xhr, status, err) {
          console.error("../model/store_new_track.php?url=", status, err.toString());
          }.bind(this)
        });
        }
        else
        {
          this.handleCuratorFormFail();
          this.refs.url.setErrorText();
          //console.log(this.refs.url);
        }
      
        //console.log(result);
      }.bind(this));
      return;
  }

  //TrackCuratorBacklog logic

  loadCuratorsSongsFromServer = () => {
      $.ajax({
        url: '/model/get_curators_week_songs.php?curatorId='+this.state.curatorId+'&displayResults',
        dataType: 'json',
        cache: false,
        success: function(trackList) {
          if(JSON.stringify(trackList) !=  JSON.stringify(this.state.trackListCuratorBacklog))
          {
            this.setState({trackListCuratorBacklog: trackList});
            this.state.trackListCuratorBacklog.length > 0 ? this.getTrackTitles(this.state.trackListCuratorBacklog) :  this.setState({trackListCuratorBacklogProper: trackList});;
          }
        }.bind(this),
        error: function(xhr, status, err) {
          console.error('/model/get_curators_week_songs.php?curatorId=', status, err.toString());
        }.bind(this)
      });
  }

  getTrackTitles = (trackListUrl) => {

      var that                  = this;
      var ajaxRequestNumber     = 0;
      var ajaxRequestCompleted  = 0;
      var trackListProper       = this.state.trackListCuratorBacklog;

      for(var indexTrackList  = 0, trackListLength = trackListUrl.length ; indexTrackList < trackListLength ; indexTrackList++)
      {
        var urlCopy = trackListUrl[indexTrackList].url;
        //console.log(indexTrackList + " url: " + urlCopy);

        if(urlCopy.toLowerCase().indexOf("youtube") > -1 )
        {
          urlValidityTester(urlCopy, function(result){
            var trackIdCopy = result;
            (function(trackIdCopy, indexTrackList){

                           $.ajax({
                              url: "https://www.googleapis.com/youtube/v3/videos?id="+ trackIdCopy +"&key=AIzaSyAzc_ihjBq03TOwwPqkt1ZgfT6ouEJ5plI&part=snippet",
                              dataType: 'json',
                              cache: false,
                              success: function(song) {
                                trackListProper[indexTrackList].title       = song.items[0].snippet.title;
                                if(isFinished(indexTrackList))
                                {
                                  that.setState({trackListCuratorBacklogProper: trackListProper, isCuratorBacklogLoaded: true});
                                  console.log("Tracklist after all calls:" + that.state.trackListProper);
                                  //callBack();
                                } 
                                //console.log(trackListProper);
                              }.bind(this),
                              error: function(xhr, status, err) {
                                console.error("https://www.googleapis.com/youtube/v3/videos?id=", status, err.toString());
                              }.bind(this)
                            });
            })(trackIdCopy, indexTrackList);
            //console.log(trackIdCopy);
          }.bind(this));
          ajaxRequestNumber++;
        }

        else if(urlCopy.toLowerCase().indexOf("soundcloud") > -1 ){


          (function(urlCopy, indexTrackList){
            //console.log(urlCopy);
            SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
            {
              if(track)
              {
                trackListProper[indexTrackList].title  = track.title;
              }

              if(isFinished(indexTrackList))
              {
                //that.trackList = trackListProper;
                that.setState({trackListCuratorBacklogProper: trackListProper, isCuratorBacklogLoaded: true});
                console.log("Tracklist after all calls:" + that.state.trackListProper);
                //callBack();
              } 
            });
          })(urlCopy, indexTrackList);
          ajaxRequestNumber++;
      }
    }
    var isFinished = function(index){
      ajaxRequestCompleted++;
      //console.log('Ajax Req Number: ' + ajaxRequestNumber);
      //console.log('Ajax Req Completed: ' + ajaxRequestCompleted);
      if(ajaxRequestCompleted === ajaxRequestNumber){
        console.log('completed! Launching callback...');
        return true;
      }
    }
  }

  removeTrackFromSubmissions = (trackId) => {
    //console.log("url: /model/remove_submitted_track.php?trackId="+trackId+"&displayResults");
    $.ajax({
      url: "/model/remove_submitted_track.php?trackId="+trackId+"&displayResults",
      cache: false,
      success: function(success) {
        console.log("removed");
        this.loadCuratorsSongsFromServer();
      }.bind(this),
      error: function(xhr, status, err) {
        console.error("/model/remove_submitted_track.php?trackId="+trackId+"&displayResults", status, err.toString());
      }.bind(this)
    });
  }

  displayCuratorPopUp = () => {
    console.log('hejbfzn');
    curatorPopup(function(){
      this.setState({isCurator: true});
      this.setState({isPanelDisplayed: true});
    }.bind(this));
  }


  componentDidMount() {
    this.loadUserPseudo();
    this.loadUserAvatar();
    this.loadUserType();
    this.loadUserId();
    this.loadCuratorId();
    $(document).mouseup(function (e)
    {
        var container = $(".dropdown");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            document.getElementById("dropdownCheckbox").checked = false;
            this.setState({isDisplayed: false});
        }
    }.bind(this));
  }

  render() {  

    var pseudo          = this.state.userName.length > 13 ? this.state.userName.substring(0, 13) : this.state.userName;
    var imagetag        = this.state.userAvatarUrl ? <img id="toggler" src={this.state.userAvatarUrl}/>  : <div id="togglerDiv">{this.state.userName.substring(0, 1).toUpperCase()}</div>;
    var secondLink      = this.state.isCurator ? <li><a onClick={this.handlePanelClick} href="#">My Tracks</a></li> : <li><a href="#" onClick={this.displayCuratorPopUp}>Become a curator</a></li>;
    var thirdLink       = this.state.isCurator ? "" : <li><a href="#" onClick={this.handlePanelClick}>Tracks Liked</a></li>;
    
    var panelDisplayed  = !this.state.isCurator ? <UserPanel 
                                                    isDisplayed                   = {true} 
                                                    pollInterval                  = {this.props.pollInterval}
                                                    closePanel                    = {this.closePanel} 
                                                    loadLikedTracksFromServer     = {this.loadLikedTracksFromServer}
                                                    isLoadedLikedSongs            = {this.state.isLoadedLikedSongs}
                                                    trackListLikedSongsProper     = {this.state.trackListLikedSongsProper}/> 
                          :
                                                  <CuratorPanel 
                                                    isDisplayed                   = {true} 
                                                    pollInterval                  = {this.props.pollInterval}
                                                    handleCuratorFormSuccess      = {this.handleCuratorFormSuccess} 
                                                    handleCuratorFormFail         = {this.handleCuratorFormFail}
                                                    closePanel                    = {this.closePanel} 
                                                    curatorId                     = {this.state.curatorId}
                                                    curatorFormSuccessMessage     = {this.state.curatorFormSuccessMessage}
                                                    curatorFormFailMessage        = {this.state.curatorFormFailMessage}
                                                    loadLikedTracksFromServer     = {this.loadLikedTracksFromServer}
                                                    isLoadedLikedSongs            = {this.state.isLoadedLikedSongs}
                                                    trackListLikedSongsProper     = {this.state.trackListLikedSongsProper}
                                                    handleCuratorUrlSubmit        = {this.handleCuratorUrlSubmit}
                                                    loadCuratorsSongsFromServer   = {this.loadCuratorsSongsFromServer}
                                                    trackListCuratorBacklogProper = {this.state.trackListCuratorBacklogProper}
                                                    isCuratorBacklogLoaded        = {this.state.isCuratorBacklogLoaded}
                                                    removeTrackFromSubmissions    = {this.removeTrackFromSubmissions}/>;

    var panelEmpty    = !this.state.isCurator ? <UserPanel closePanel={this.closePanel} isDisplayed={false}/> : <CuratorPanel closePanel={this.closePanel} isDisplayed={false}/>;

    var panelTag      = this.state.isPanelDisplayed ? panelDisplayed : panelEmpty;

    return (
      <div>
        <div className="container-dropdown">
          <ul>
            <li className="dropdown">
              <input type="checkbox" checked={this.state.isDisplayed} id="dropdownCheckbox" onChange={this.handleChange} />
              <a href="#" data-toggle="dropdown">
                {pseudo}
                {imagetag}        
              </a>
              <ul className="account-dropdown-menu">
                {secondLink}
                {thirdLink}
                <li><a href="../view/settings.php" target="_blank">My account</a></li>
                <li><a href="../control/logout.php">Log out</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div> {panelTag} </div>
      </div>
    )
  }
}

class CuratorPanel extends React.Component {

  
  componentWillReceiveProps = (nextProps) => {
    if(nextProps.isDisplayed && (nextProps.isDisplayed != this.props.isDisplayed))
    {
      nextProps.loadCuratorsSongsFromServer();
    }
  }

  render() {

    if(this.props.isDisplayed)
    {
      $(document).mouseup(function (e)
      {
          var container = $("#left-pannel");

          if (!container.is(e.target) // if the target of the click isn't the container...
              && container.has(e.target).length === 0) // ... nor a descendant of the container
          {
              this.props.closePanel();
          }
      }.bind(this));
    }

    //console.log('isrendered, isDisplayed: '+ this.props.isDisplayed);
    var tag = this.props.isDisplayed ? 
      <div id="left-pannel">
        <div className="closePannel" onClick={this.props.closePanel}>Close <i className="material-icons closePannelIcon">keyboard_arrow_down</i></div>
        <div className="pannelTabs">
          <Tabs 
            inkBarStyle={{backgroundColor: "#32B7A2"}} 
            tabItemContainerStyle={{backgroundColor: "transparent"}}
            contentContainerStyle={{color:"white"}}>
            <Tab 
            label="SUBMIT TRACKS" 
            onActive={this.props.loadCuratorsSongsFromServer}>
              <SubmitTracksForm 
                handleCuratorFormSuccess      = {this.props.handleCuratorFormSuccess} 
                handleCuratorFormFail         = {this.props.handleCuratorFormFail}
                curatorId                     = {this.props.curatorId} 
                curatorFormSuccessMessage     = {this.props.curatorFormSuccessMessage} 
                curatorFormFailMessage        = {this.props.curatorFormFailMessage}
                handleCuratorUrlSubmit        = {this.props.handleCuratorUrlSubmit}/>
              <TrackCuratorBacklog 
                curatorId                     = {this.props.curatorId} 
                pollInterval                  = {this.props.pollInterval}
                trackListCuratorBacklogProper = {this.props.trackListCuratorBacklogProper}
                isCuratorBacklogLoaded        = {this.props.isCuratorBacklogLoaded}
                removeTrackFromSubmissions    = {this.props.removeTrackFromSubmissions}/> 
            </Tab>
            <Tab label="HISTORY" >
              Under (re)construction, will come back soon!
            </Tab>
            <Tab 
              label="TRACKS LIKED"
              onActive={this.props.loadLikedTracksFromServer}>
              <TracksLiked 
                userId={this.props.userId} 
                isLoadedLikedSongs={this.props.isLoadedLikedSongs}
                trackListLikedSongsProper={this.props.trackListLikedSongsProper}
                pollInterval={this.props.pollInterval}/>
            </Tab>
          </Tabs>
        </div>
      </div> : "";

      return (
        <ReactCSSTransitionGroup transitionName="panel" transitionEnterTimeout={300} transitionLeaveTimeout={300}>
          {tag}
        </ReactCSSTransitionGroup>
      )
    }
}

class UserPanel extends React.Component {


  render() {

    if(this.props.isDisplayed)
    {
      $(document).mouseup(function (e)
      {
          var container = $("#left-pannel");

          if (!container.is(e.target) // if the target of the click isn't the container...
              && container.has(e.target).length === 0) // ... nor a descendant of the container
          {
              this.props.closePanel();
          }
      }.bind(this));
    }

    //console.log('isrendered, isDisplayed: '+ this.props.isDisplayed);
    var tag = this.props.isDisplayed ? 
      <div id="left-pannel">
        <div className="closePannel" onClick={this.props.closePanel}>Close <i className="material-icons closePannelIcon">keyboard_arrow_down</i></div>
        <div className="pannelTabs">
          <TracksLiked 
                userId={this.props.userId} 
                isLoadedLikedSongs={this.props.isLoadedLikedSongs}
                trackListLikedSongsProper={this.props.trackListLikedSongsProper}/>
        </div>
      </div> : "";

      return (
        <ReactCSSTransitionGroup transitionName="panel" transitionEnterTimeout={300} transitionLeaveTimeout={300}>
          {tag}
        </ReactCSSTransitionGroup>
      )
    }
}

class SubmitTracksForm extends React.Component {
  
  constructor(props) {
      super(props);
      this.state = {
        url: ""
      };
  }

  handleUrlChange = (e) => {
    this.setState({url: e.target.value});
  }

  handleCuratorUrlSubmit = (e) => {
      e.preventDefault();
      this.props.handleCuratorUrlSubmit(e, this.state.url);
      this.setState({url: ""});
  }

  render() {
    var successTag  = this.props.curatorFormSuccessMessage ? <div className="successContainerForm"><i className="material-icons checkMark">check_circle</i><span className="successMessageForm">Got your tune, thanks!</span></div> : "";
    var failTag     = this.props.curatorFormFailMessage ? <div className="successContainerForm"><i className="material-icons failMark">cancel</i><span className="failMessageForm">Error: We couldn't recognize this URL format. Be sure it's Soundcloud or Youtube standard track link!</span></div> : "";
    return (
      <div className="pannelSubContainer">
        <form className="postNewSong" onSubmit={this.handleCuratorUrlSubmit}>
          <TextField
            className="urlNewSong"
            autoFocus={true}
            underlineFocusStyle={{borderColor: "#32B7A2"}}
            underlineStyle={{borderColor: "rgba(255,255,255, 0.3)"}}
            hintStyle={{color: "rgba(255,255,255, 0.6)", fontWeight: "300"}}
            inputStyle={{color: "rgba(255,255,255, 0.8)", fontWeight: "300"}}
            floatingLabelStyle={{color: "#32B7A2", fontWeight: "300"}}
            type="url"
            floatingLabelText="Paste a Soundcloud or Youtube URL here:"
            defaultValue=""
            ref="url"
            value={this.state.url}
            style={{ width: '51vw', marginRight: '20px', minWidth:'580px'}}
            onChange={this.handleUrlChange} />
        <FlatButton 
          label="SUBMIT!" 
          primary={true}
          hoverColor="#531931"
          rippleColor="#32B7A2"
          labelStyle={{color: "rgba(255,255,255, 0.8)"}}
          style={{backgroundColor: 'rgba(50,183,162, 0.2)'}}
          onTouchTap={this.handleCuratorUrlSubmit} />
        <ReactCSSTransitionGroup transitionName="successMessage" transitionEnterTimeout={300} transitionLeaveTimeout={300}>
          {successTag}
        </ReactCSSTransitionGroup>
        <ReactCSSTransitionGroup transitionName="failMessage" transitionEnterTimeout={300} transitionLeaveTimeout={300}>
          {failTag}
        </ReactCSSTransitionGroup>
      </form>
    </div>
    );
  }
}

class TrackCuratorBacklog extends React.Component {


  render() {

    if(this.props.isCuratorBacklogLoaded)
    {
      var rowTags = [];
      this.props.trackListCuratorBacklogProper.map(function(track){
        //console.log(parseInt(track.ID));
        rowTags.push(
          <TableRow key={parseInt(track.ID)} rowNumber={parseInt(track.ID)}>
            <TableRowColumn>
              {track.title}
            </TableRowColumn>
            <TableRowColumn>
              {track.dateAdd}
            </TableRowColumn>
            <TableRowColumn>
              <a className="curatorTrackTableActions" href={track.url} target="_blank"><i className="material-icons failMark">link</i>link</a>
              <a className="curatorTrackTableActions" onClick={this.props.removeTrackFromSubmissions.bind(this, parseInt(track.ID))}><i className="material-icons failMark">cancel</i>remove</a>
            </TableRowColumn>
          </TableRow>);
      }.bind(this));
      //console.log(rowTags);
    }

    return (
      <div className="trackBacklog">
        <h2 className="pannelTitle">Tracks Already Submitted, pending for validation:</h2>
        <div className="pannelSubContainer">
          <Table
            height={'300px'}
            fixedHeader={true}
            fixedFooter={false}
            selectable={false}
            style={{backgroundColor: 'transparent', fontFamily:"'Roboto'"}}>
            <TableHeader adjustForCheckbox={false} displaySelectAll={false} enableSelectAll={false}>
              <TableRow>
                <TableHeaderColumn tooltip='Title'>Title</TableHeaderColumn>
                <TableHeaderColumn>Date posted</TableHeaderColumn>
                <TableHeaderColumn tooltip='Actions'>Actions</TableHeaderColumn>
              </TableRow>
            </TableHeader>
            <TableBody
              deselectOnClickaway={true}
              showRowHover={true}
              stripedRows={false}
              displayRowCheckbox={false}>
              {rowTags}
            </TableBody>
          </Table>
        </div>
      </div>  
    );
  }
} 

class TracksLiked extends React.Component {

  render() {

     var songTags = [];
    if(this.props.isLoadedLikedSongs)
    {
      console.log('Likes tracks loaded');
      this.props.trackListLikedSongsProper.map(function(track){
        //console.log(parseInt(track.ID));
        songTags.push(
          <div key={track.ID} id="box1" className="box">
            <div className="boxInner">
              <h3 className="curator">
                <div className="curatorText">
                  <span style={{backgroundColor: "black"}}>Curator: {track.pseudo}</span>
                  <div className="curatorStuff">
                    <img className="curatorPicture" src={track.avatarUrl} />
                  </div>
                </div>
              </h3>
              <img src={track.coverUrl} className="sound_cover"></img> 
              <h2 className="likeTilesTrackTitle"><a href={track.url} target="_blank">{track.title}</a></h2>
            </div>
          </div>
        );
      }.bind(this));
      //console.log(songTags);
    }
    else
    {
      for(var index = 0 ; index < 12 ; index++)
      {
        songTags.push(
          <div key={index} id="box1" className="box">
            <div className="boxInner loading .animated-background">
            </div>
          </div>
        );
      }
    }
    return (
      <div id="tilesContainer">{songTags}</div>
    );
  }
}



ReactDOM.render(
  <DropDownMenu pollInterval={10000}/>,
    document.getElementById('extraOptions')
);

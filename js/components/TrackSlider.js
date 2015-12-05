// React and react router
import React from 'react';
import ReactDOM from 'react-dom';

import Slider from '../../node_modules/material-ui/lib/slider';

export default class TrackSlider extends React.Component {

	constructor(props) {
	    super(props);

      this.state = {
              timer: 0,
              position: 0,
              sliderState: false
            };

      this.handleSliderChange           = this.handleSliderChange.bind(this);
      this.startMonitoringCurrentTrack  = this.startMonitoringCurrentTrack.bind(this);
      this.handleSliderChange           = this.handleSliderChange.bind(this);
	  }
  	
  handleSliderChange(event, value) {
      this.props.currentTrack.setDuration(value * this.props.currentTrack.getDuration());
	}

  updateValue(positionInSeconds){
    //this.setState({timer: positionInSeconds});
  }

  startMonitoringCurrentTrack() {
    //setting some variables to clean code down the road
    var currentTrackCopy  = this.props.currentTrack;
    var trackPosition     = currentTrackCopy.getPosition();
    var durationEstimate  = currentTrackCopy.getDuration();
    var progressRate      = (trackPosition / durationEstimate);
    //console.log("trackPosition: "+ trackPosition + "durationEstimate: "+durationEstimate);

    //formating minutes and seconds
    var divider = durationEstimate > 50000 ? 1000 : 1;
    //console.log(divider);
    var minutes = (trackPosition / (60*divider)) | (0);
    var seconds = Math.round(trackPosition/divider - minutes * 60);
    seconds = seconds < 10 ? ('0' + seconds) : seconds;
    //console.log("minutes: "+minutes+" seconds: "+seconds);

    //update states
    var timer = !minutes ?  seconds : (minutes + ':' + seconds);
    //console.log("timer: "+ timer)
    this.setState({
      timer: timer,
      position: progressRate});
  }

  componentDidMount() {

    console.log("Trackslider Mounted");
  }

    componentWillUnmount() {

    console.log("Trackslider Mounted");
    this.loadInterval && clearInterval(this.loadInterval);
    this.loadInterval = false;
  }

  componentWillReceiveProps(nextProps) {
    console.log(nextProps.currentTrack !== this.props.currentTrack);
    if(nextProps.currentTrack !== this.props.currentTrack && Object.keys(nextProps.currentTrack).length != 0){
      console.log('uefykzglfkjzen');
      this.startMonitoringCurrentTrack;
      this.loadInterval = setInterval(this.startMonitoringCurrentTrack, 1000);
      this.setState({sliderState: true});
    }
  }

  render() {

    var timerSpan = this.state.timer ? <span id="timer">{this.state.timer}</span> : "";

    return (
        <div id="playerCommands">
          {timerSpan}
          <Slider 
            name="slider1" 
            value={this.state.position}
            disabled={!this.state.sliderState}
            onChange={this.handleSliderChange}
            style={{ width: '80vw', display: 'inline-block', marginTop: '8px'}} />
        </div>
    );
  }
}
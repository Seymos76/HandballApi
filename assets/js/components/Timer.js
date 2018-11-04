import React, { Component } from 'react'

class Timer extends Component {
    constructor(props) {
        super(props);
        this.state = {
            targetDate: props.targetDate,
            date: new Date(),
            targetDay: 'day',
            targetMount: 'month',
            targetYear: 'year',
        }
    }
    componentDidMount() {
        this.timerID = setInterval(
            () => this.tick(),
            1000
        );
        console.log(this.state.targetDate)
        /*this.targetDay = this.state.targetDate.slice(0,2)
        this.targetMonth = this.state.targetDate.slice(3,5)
        this.targetYear = this.state.targetDate.slice(6,this.state.targetDate.length)*/
    }
    componentWillUnmount() {
        clearInterval(this.timerID)
    }
    tick() {
        this.setState({
            date: new Date()
        });
    }
    render() {
        return (
            <div>
                Timer: {this.state.date.toLocaleTimeString()}
                Jour: {this.state.targetDay}
                Jour: {this.state.targetDay}
                </div>
        )
    }
}

export default Timer
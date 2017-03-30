import React from 'react';
import ReactDOM from 'react-dom';
import autobahn from 'autobahn';

// const React = require('react');
// const ReactDOM = require('react-dom');

const Content = React.createClass({

    getInitialState() {
        return {
            connection: null
        }
    },

    componentWillMount() {
        this.connection = new autobahn.Connection({
            url: 'ws://localhost:1337/app',
            realm: 'realm1'
        });
        console.log('hey');
        this.connection.onopen = function (session) {
            console.log(session);
            console.log()
        }
        // this.connection = new WebSocket('wss://echo.websocket.org');
        // this.connection.onmessage = event => {
        //     console.log(event.data);
        // }
        //
        // setInterval(_ => {
        //     this.connection.send(Math.random());
        // }, 10000);
    },

    render() {
        return (
            <article>
                <header>Hey {this.props.test} welcome to MySQL query explain project :)</header>
            </article>
        );
    }
});
ReactDOM.render(<Content />, document.getElementById('content'));

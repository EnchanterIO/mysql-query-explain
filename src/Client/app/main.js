import React from 'react';
import ReactDOM from 'react-dom';

// const React = require('react');
// const ReactDOM = require('react-dom');

const Content = React.createClass({

    getInitialState() {
        return {
            connection: null,
            dbConfig: {}
        }
    },

    componentWillMount() {
        this.connection = new WebSocket('ws://localhost:1337/app');

        this.connection.addEventListener('open', event => {
            console.log('boom');
        });

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

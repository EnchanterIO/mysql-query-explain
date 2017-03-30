import React from 'react';
import ReactDOM from 'react-dom';
import DbInfo from './dbInfo';

// const React = require('react');
// const ReactDOM = require('react-dom');

const Content = React.createClass({

    getInitialState() {
        return {
            connection: null,
            dbConfig: {
                database: '',
                hostname: '',
                username: ''
            }
        }
    },

    componentWillMount() {
        this.connection = new WebSocket('ws://localhost:1337');
        this.connection.onmessage = event => {
            // yes we like JSON.parse
            const message = JSON.parse(JSON.parse(event.data));

            const dbConfig = Object.assign(
                {},
                message.config
            );

            let state = this.state;
            state.dbConfig = dbConfig;
            this.setState(state);
        }
        setTimeout(_ => {
            this.connection.send("SELECT * FROM tablename;");
        }, 1000);
    },

    render() {
        return (
            <article>
                <header>Hey welcome to MySQL query explain project :)</header>
                <DbInfo dbConfig={this.state.dbConfig}></DbInfo>
            </article>
        );
    }
});
ReactDOM.render(<Content />, document.getElementById('content'));

import React from 'react';
import ReactDOM from 'react-dom';
import DbInfo from './dbInfo';
import QueryInfo from './queryInput';
import AnalyzeOutput from './analyzeOutput';

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
            },
            queryMessages: []
        }
    },

    setDbConfig(config) {
        const dbConfig = Object.assign({}, config);

        let state = this.state;
        state.dbConfig = dbConfig;
        this.setState(state);
    },

    setQueryMessages(queryMessage) {
        let state = this.state;
        state.queryMessages.push(queryMessage);
        this.setState(state);
    },

    handleAnalyzeSubmit(query) {
        this.state.connection.send(query);
        console.log('hey I am here');
    },

    componentWillMount() {
        let connection = new WebSocket('ws://localhost:1337');
        connection.onmessage = event => {
            // yes we like JSON.parse
            const jsonBody = JSON.parse(event.data);
            const body = JSON.parse(jsonBody.body);
            
            if (undefined !== body.config) {
                this.setDbConfig(body.config);
            } else {
                this.setQueryMessages(message.queryMessage);
            }
        }
        let state = this.state;
        state.connection = connection;
        this.setState(state);
    },

    render() {
        return (
            <article>
                <header>Hey welcome to MySQL query explain project :)</header>
                <DbInfo dbConfig={this.state.dbConfig} />
                <QueryInfo onSubmit={this.handleAnalyzeSubmit} />
                <AnalyzeOutput messages={this.state.queryMessages} />
            </article>
        );
    }
});
ReactDOM.render(<Content />, document.getElementById('content'));

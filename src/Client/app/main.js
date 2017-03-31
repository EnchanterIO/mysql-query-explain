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
            queryMessages: ['test', 'test1']
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
        state.queryMessages.push('Lukas litro');
        this.setState(state);
    },

    handleAnalyzeSubmit(query) {
        this.state.connection.send(query);
        console.log('hey I am here');
    },

    componentWillMount() {
        let connection = new WebSocket('ws://localhost:1337');
        connection.onmessage = event => {
            const message = JSON.parse(event.data);

            if (undefined !== message.body.config) {
                this.setDbConfig(message.body.config);
            } else {
                this.setQueryMessages(message.body.queryMessage);
            }
        }
        let state = this.state;
        state.connection = connection;
        this.setState(state);
    },

    render() {
        return (
            <article>
                <div className="row">
                    <DbInfo dbConfig={this.state.dbConfig} />
                </div>
                <div className="row">
                    <QueryInfo onSubmit={this.handleAnalyzeSubmit} />
                </div>
                <div className="row">
                    <AnalyzeOutput messages={this.state.queryMessages} />
                </div>
            </article>
        );
    }
});
ReactDOM.render(<Content />, document.getElementById('content'));

import React from 'react';
import ReactDOM from 'react-dom';
import DbInfo from './Component/DbInfo';
import QueryInput from './Component/QueryInput';
import AnalyzeOutput from './Component/AnalyzeOutput';

// const React = require('react');
// const ReactDOM = require('react-dom');

const Application = React.createClass({

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
        let state = this.state;
        state.queryMessages = [];
        this.setState(state)
        this.state.connection.send(query);
    },

    componentWillMount() {
        let connection = new WebSocket('ws://localhost:1337');
        connection.onmessage = event => {
            const message = JSON.parse(event.data);

            if (undefined !== message.body.config) {
                this.setDbConfig(message.body.config);
            } else if (undefined !== message.body.progress) {
                this.setQueryMessages(message.body.progress);
            } else {
                console.log('what the fuck are you sending to me?, leave my socket alone please :)');
            }
        }
        let state = this.state;
        state.connection = connection;
        this.setState(state);
    },

    render() {
        return (
            <article>
                <header className="row">
                    <DbInfo dbConfig={this.state.dbConfig} />
                </header>
                <QueryInput onSubmit={this.handleAnalyzeSubmit} />
                <AnalyzeOutput messages={this.state.queryMessages} />
            </article>
        );
    }
});
ReactDOM.render(<Application />, document.getElementById('application'));

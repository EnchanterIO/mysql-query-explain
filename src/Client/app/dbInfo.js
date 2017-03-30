import React from 'react';

class DbInfo extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <ul>
                <li>Db: {this.props.dbConfig.database}</li>
                <li>Host: {this.props.dbConfig.hostname}</li>
                <li>User: {this.props.dbConfig.username}</li>
            </ul>
        );
    }
}

export default DbInfo;

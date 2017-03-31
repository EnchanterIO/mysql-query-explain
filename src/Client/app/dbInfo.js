import React from 'react';

class DbInfo extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="col">
                <h5>DB connection info:</h5>
                <p><span><b>Db:</b> {this.props.dbConfig.database}</span> <span><b>Host:</b> {this.props.dbConfig.hostname}</span> <span><b>User:</b> {this.props.dbConfig.username}</span></p>
            </div>
        );
    }
}

export default DbInfo;

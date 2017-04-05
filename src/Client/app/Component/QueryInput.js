import React from 'react';

class QueryInput extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: ""
        }
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({value:event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();
        // we don't want to send the ; to the server
        let query = this.state.value.trim();
        if (";" === query.slice(-1)) {
            debugger;
            query = query.slice(0, -1);
        }
        this.props.onSubmit(query);
    }

    render() {
        return (
            <div className="row">
                <div className="col">
                    <form onSubmit={this.handleSubmit}>
                        <div className="form-group">
                            <label htmlFor="queryInputArea">Query:</label>
                            <textarea id="queryInputArea" className="form-control" value={this.state.value} onChange={this.handleChange} rows="15"></textarea>
                        </div>
                        <button className="btn btn-outline-primary" type="submit">Analyze</button>
                    </form>
                </div>
            </div>
        );
    }
}

export default QueryInput;

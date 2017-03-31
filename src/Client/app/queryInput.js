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
        this.props.onSubmit(this.state.value);
    }

    render() {
        return (
            <div className="col">
                <form onSubmit={this.handleSubmit}>
                    <div className="form-group">
                        <label htmlFor="queryInputArea">Query:</label>
                        <textarea id="queryInputArea" className="form-control" value={this.state.value} onChange={this.handleChange} rows="15"></textarea>
                    </div>
                    <button className="btn btn-outline-primary" type="submit">Analyze</button>
                </form>
            </div>
        );
    }
}

export default QueryInput;

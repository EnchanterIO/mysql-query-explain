import React from 'react';


class AnalyzeOutput extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const messages = this.props.messages.map((message, id) => {
            return <li key={id}>{message}</li>
        });
        return (
            <ul>
                {messages}
            </ul>
        );
    }
}

export default AnalyzeOutput;

import React from 'react';

class Progress extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        debugger;
        let tableHeaders = this.props.stats[0].keys();
        // const tableRows;

        return (
            <div>
            <p>{this.props.message}</p>
            <table className="table table-bordered">
                <thead>
                <tr>
                    {tableHeaders}
                </tr>
                </thead>
                <tbody>
                <tr>

                </tr>
                </tbody>


            </table>
            </div>
        )
    }
}

export default Progress;

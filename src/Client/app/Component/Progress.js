import React from 'react';

class Progress extends React.Component {
    constructor(props) {
        super(props);
    }

    getTableHeaders() {
        const headers = Object.keys(this.props.stats[0]);
        const tableHeaders = headers.map((header, id) => {
            return <th key={id}>{header}</th>
        });

        return tableHeaders;
    }

    getTableBody() {
        const tableBody = this.props.stats.map((row, id) => {
            return <tr key={id}>
                {this.getTableRow(row)}
            </tr>
        });

        return tableBody;
    }

    getTableRow(row) {
        const values = Object.values(row);
        const tableRow = values.map((col, id) => {
            if (null === col) {
                col = "null";
            }
            return <td key={id}>{col}</td>
        });

        return tableRow;
    }

    render() {
        let table = null;
        if (this.props.stats.length > 0) {
            const tableHeaders = this.getTableHeaders();
            const tableBody = this.getTableBody();
            table = <table className="table table-bordered">
                <thead>
                <tr>
                    {tableHeaders}
                </tr>
                </thead>
                <tbody>
                    {tableBody}
                </tbody>


            </table>
        }
        // let tableHeaders = this.props.stats[0].keys();
        // const tableRows;



        return (
            <div>
            <p>{this.props.message}</p>
            {table}
            </div>
        )
    }
}

export default Progress;

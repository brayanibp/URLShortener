import { useState } from 'react';
import { Link } from '@inertiajs/react';
import { Tooltip } from 'react-tooltip';
import './style.css';
import axios from 'axios';

export default function Index({ urls }) {
    const [myUrls, setUrls] = useState(urls);
    const [error, setError] = useState(null);

    const handleDelete = async (url) => {
        try {
            const res = await axios.delete(`/api/${url}`);
            setUrls(res.data.urls);
        } catch (error) {
            console.log(error);
            setError(error.response.data.error);
        }
    }

    return (
        <div className='dashboard'>
            <h1>URL Shortener</h1>
            <Tooltip id="add-tooltip" />
            <Link
                href={'/add'}
                class="add-button"
                data-tooltip-id="add-tooltip"
                data-tooltip-content={`Shorten a new URL`}
                data-tooltip-place="top"
            >
                Add URL
            </Link>
            <table className='urls-table'>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Code</th>
                        <th>Original URL</th>
                        <th></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {myUrls.map((url, index) => (
                        <tr key={index}>
                            <td>{index + 1}</td>
                            <td>
                                <span>{url.short_url}</span>
                            </td>
                            <td>
                                <span>{url.original_url}</span>
                            </td>
                            <td>
                                <Tooltip id="goto-tooltip" />
                                <Link
                                    className="goto"
                                    data-tooltip-id="goto-tooltip"
                                    data-tooltip-content={`Go to ${window.location.href}${url.short_url}`}
                                    data-tooltip-place="top"
                                    href={url.short_url}
                                >
                                    🔗
                                </Link>
                            </td>
                            <td>
                                <Tooltip id="delete-tooltip" />
                                <button
                                    data-tooltip-id="delete-tooltip"
                                    data-tooltip-content={"Delete URL"}
                                    data-tooltip-place="top"
                                    onClick={() => handleDelete(url.short_url)}
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

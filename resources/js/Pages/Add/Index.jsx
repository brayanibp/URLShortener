import { useEffect, useState } from 'react';
import { Link } from '@inertiajs/react';
import { Tooltip } from 'react-tooltip';
import axios from 'axios';
import './style.css';

export default function Index() {
    const [error, setError] = useState(null);

    const handleAdd = async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        if (!data.url) {
            setError('Please enter a URL');
            return;
        } else {
            setError(null);
        }
        try {
            await axios.post('/api/generate-short-url', data);
            form.reset();
        } catch (err) {
            setError(err.response.data.message);
        }
    }

    useEffect(() => {
        document.querySelector('input').focus();
    }, [error]);
    return (
        <div className='add'>
            <Tooltip id='goback-tooltip' />
            <Link
                href={'/'}
                data-tooltip-id='goback-tooltip'
                data-tooltip-content='Go back to dashboard'
                data-tooltip-place='top'
                className='goback'
            >
               ⬅️ Back
            </Link>
            <h2>Add a URL</h2>
            <form action='' onSubmit={handleAdd}>
                <Tooltip id='add-tooltip' />
                <input
                    name='url'
                    type='text'
                    placeholder='Enter a URL'
                    data-tooltip-id='add-tooltip'
                    data-tooltip-content='Enter a new URL'
                    data-tooltip-place='top'
                />
                <div className='error'>{error}</div>
                <button
                    data-tooltip-id='add-tooltip'
                    data-tooltip-content='Confirm the new URL'
                    data-tooltip-place='top'
                >
                    Add new URL
                </button>
            </form>
        </div>
    );
}

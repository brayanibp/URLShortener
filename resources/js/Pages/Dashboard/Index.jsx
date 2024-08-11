import { Link } from '@inertiajs/react';
import './style.css';

export default function Index({ urls }) {
    return (
        <div className='dashboard'>
            <h1>URL Shortener</h1>
            <Link href={'/add'}>Add</Link>
            <ul>
                {urls.map((url, index) => (
                    <li key={index}>
                        <a href={url.original_url}>{url.original_url}</a>
                        <a href={url.original_url}>{url.short_url}</a>
                    </li>
                ))}
            </ul>
        </div>
    );
}

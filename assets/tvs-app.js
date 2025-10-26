import { createRoot } from 'react-dom/client';
import React, { useEffect, useState, useRef } from 'react';
import DevOverlay from './dev-overlay';

// Helper function to format time as MM:SS
function formatTime(seconds) {
	const mins = Math.floor(seconds / 60);
	const secs = Math.floor(seconds % 60);
	return `${mins}:${secs.toString().padStart(2, '0')}`;
}

// ProgressBar component
function ProgressBar({ currentTime, duration }) {
	const progress = duration > 0 ? (currentTime / duration) * 100 : 0;

	return (
		<div className="tvs-progress">
			<div className="tvs-progress__bar">
				<div
					className="tvs-progress__fill"
					style={{ width: `${Math.min(progress, 100)}%` }}
				/>
			</div>
			<div className="tvs-progress__time">
				{formatTime(currentTime)} / {formatTime(duration)}
			</div>
		</div>
	);
}

function VirtualRouteApp({ routeId }) {
	const [data, setData] = useState(null);
	const [currentTime, setCurrentTime] = useState(0);
	const [lastStatus, setLastStatus] = useState('loading');
	const [lastError, setLastError] = useState(null);
	const videoRef = useRef(null);

	// Check for debug mode
	const DEBUG = 
		new URLSearchParams(location.search).get('tvsdebug') === '1' ||
		localStorage.getItem('tvsDev') === '1';

	useEffect(() => {
		setLastStatus('loading');
		fetch(`/wp-json/tvs/v1/routes/${routeId}`)
			.then((res) => res.json())
			.then((json) => {
				setData(json);
				setLastStatus('ok');
			})
			.catch((err) => {
				console.error(err);
				setLastError(err.message || String(err));
				setLastStatus('error');
			});
	}, [routeId]);

	// Bind to video timeupdate event
	useEffect(() => {
		const video = videoRef.current;
		if (!video) return;

		const handleTimeUpdate = () => {
			setCurrentTime(video.currentTime);
		};

		video.addEventListener('timeupdate', handleTimeUpdate);
		return () => {
			video.removeEventListener('timeupdate', handleTimeUpdate);
		};
	}, [data]);

	if (!data) return <p>Loading route data...</p>;

	const duration = data.meta?.duration_s || 0;

	return (
		<div className="tvs-app">
			<h2>{data.title?.rendered}</h2>
			<p>
				Distance: {data.meta?.distance_m} m – Elevation:{' '}
				{data.meta?.elevation_m} m
			</p>
			<video ref={videoRef} src={data.meta?.video_url} controls width="100%" />
			<ProgressBar currentTime={currentTime} duration={duration} />
			{DEBUG && (
				<DevOverlay
					routeId={routeId}
					lastStatus={lastStatus}
					lastError={lastError}
					currentTime={currentTime}
					duration={duration}
				/>
			)}
		</div>
	);
}

// mount app if div[data-route-id] exists
document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.tvs-app-root').forEach((el) => {
		const routeId = el.dataset.routeId;
		if (routeId) createRoot(el).render(<VirtualRouteApp routeId={routeId} />);
	});
});

import React from 'react';

const Modal = ({ show, onClose, children }) => {
    if (!show) return null;

    return (
        <div className="fixed inset-0 z-50 overflow-y-auto">
            <div className="min-h-screen px-4 text-center">
                {/* Overlay */}
                <div 
                    className="fixed inset-0 bg-black bg-opacity-40 transition-opacity"
                    onClick={onClose}
                ></div>

                {/* Modal container */}
                <span className="inline-block h-screen align-middle">&#8203;</span>

                <div className="inline-block w-full max-w-4xl p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                    {/* Header */}
                    <div className="flex items-center justify-between mb-4">
                        <h3 className="text-2xl font-bold text-gray-900">
                            Chi tiết đơn hàng
                        </h3>
                        <button
                            onClick={onClose}
                            className="p-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100"
                        >
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {/* Content */}
                    <div className="mt-4">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Modal;
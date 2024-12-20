import { useState, useEffect, useRef } from 'react';
import axios from 'axios';

// Custom Hook để gửi GET request
export const useGetApi = (url, params = {}) => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const isRequestSent = useRef(false); // Cờ để kiểm soát việc gửi request

  useEffect(() => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }
  }, []);

  useEffect(() => {
    const fetchData = async () => {
      if (!isRequestSent.current) {
        isRequestSent.current = true; // Đặt cờ khi gửi request
        try {
          const response = await axios.get(url, { params });
          setData(response.data);
        } catch (err) {
          setError(err);
        } finally {
          setLoading(false);
        }
      }
    };

    fetchData();
  }, [url, params]);

  return { data, loading, error };
};

export const usePostApi = (url) => {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);

  const postData = async (payload) => {
    try {
      const response = await axios.post(url, payload);
      setData(response.data);
      return response.data; // Trả về dữ liệu để xử lý thêm
    } catch (err) {
      setError(err);
      console.error("Error in POST request:", err);
    }
  };

  return { postData, data, error };
};

export const usePutApi = (url) => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const isRequestSent = useRef(false);

  const putData = async (requestData) => {
    if (!isRequestSent.current) {
      isRequestSent.current = true;
      setLoading(true);
      try {
        const response = await axios.put(url, requestData);
        setData(response.data);
      } catch (err) {
        setError(err);
      } finally {
        setLoading(false);
      }
    }
  };

  return { data, loading, error, putData };
};

export const useDeleteApi = (url) => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const isRequestSent = useRef(false);

  const deleteData = async () => {
    if (!isRequestSent.current) {
      isRequestSent.current = true;
      setLoading(true);
      try {
        const response = await axios.delete(url);
        setData(response.data);
      } catch (err) {
        setError(err);
      } finally {
        setLoading(false);
      }
    }
  };

  return { data, loading, error, deleteData };
};

export const usePatchApi = (url) => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const isRequestSent = useRef(false);

  const patchData = async (requestData) => {
    if (!isRequestSent.current) {
      isRequestSent.current = true;
      setLoading(true);
      try {
        const response = await axios.patch(url, requestData);
        setData(response.data);
      } catch (err) {
        setError(err);
      } finally {
        setLoading(false);
      }
    }
  };

  return { data, loading, error, patchData };
};

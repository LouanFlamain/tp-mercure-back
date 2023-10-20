const EndChat = ({ data }) => {
  return (
    <div className="chat chat-end">
      <div className="chat-image avatar">
        <div className="w-10 rounded-full">
          <img src="pp/bill.jpeg" />
        </div>
      </div>
      <div className="chat-header flex items-center">
        <p className="mr-1 text-center">{data.username}</p>
      </div>
      <div className="chat-bubble">{data.message}</div>
      <time className="chat-footer opacity-50">Maintenant</time>
    </div>
  );
};
export default EndChat;
